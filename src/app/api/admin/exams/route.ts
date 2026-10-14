import { NextResponse } from "next/server";
import { isAdmin } from "@/lib/admin-auth";
import { readExamCsv, writeExamCsv, validClass } from "@/lib/school-data";
export async function GET(request: Request) {
  if (!await isAdmin()) return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  const c = new URL(request.url).searchParams.get("class") ?? "";
  if (!validClass(c)) return NextResponse.json({ error: "Invalid class." }, { status: 400 });
  try { return NextResponse.json({ content: await readExamCsv(c) }, { headers: { "Cache-Control": "no-store" } }); }
  catch { return NextResponse.json({ error: "Could not read exam schedule." }, { status: 500 }); }
}
export async function PUT(request: Request) {
  if (!await isAdmin()) return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  const body = await request.json().catch(() => ({}));
  const c = String(body.class ?? ""), content = String(body.content ?? "");
  if (!validClass(c) || content.length > 200_000) return NextResponse.json({ error: "Invalid class or schedule too large." }, { status: 400 });
  await writeExamCsv(c, content);
  return NextResponse.json({ ok: true });
}
