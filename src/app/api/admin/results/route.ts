import { NextResponse } from "next/server";
import { isAdmin } from "@/lib/admin-auth";
import { readResults, writeResults, validClass } from "@/lib/school-data";

export async function GET(request: Request) {
  if (!await isAdmin()) return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  const classNo = new URL(request.url).searchParams.get("class") ?? "";
  if (!validClass(classNo)) return NextResponse.json({ error: "Invalid class." }, { status: 400 });
  try { return NextResponse.json({ data: await readResults(classNo) }, { headers: { "Cache-Control": "no-store" } }); }
  catch { return NextResponse.json({ error: "Could not read this class file." }, { status: 500 }); }
}
export async function PUT(request: Request) {
  if (!await isAdmin()) return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  const body = await request.json().catch(() => ({}));
  const classNo = String(body.class ?? "");
  if (!validClass(classNo)) return NextResponse.json({ error: "Invalid class." }, { status: 400 });
  const data = await readResults(classNo);
  if (body.action === "delete") {
    const roll = String(body.roll ?? "").trim();
    if (!roll || !data[roll]) return NextResponse.json({ error: "Student record not found." }, { status: 404 });
    delete data[roll];
    await writeResults(classNo, data);
    return NextResponse.json({ ok: true, count: Object.keys(data).length });
  }
  if (body.data && typeof body.data === "object" && !Array.isArray(body.data)) {
    const entries = Object.entries(body.data as Record<string, unknown>);
    if (entries.length > 10000 || entries.some(([k,v]) => !k.trim() || !v || typeof v !== "object" || Array.isArray(v))) {
      return NextResponse.json({ error: "Invalid class data. Expected a map of roll numbers to student objects." }, { status: 400 });
    }
    await writeResults(classNo, body.data);
    return NextResponse.json({ ok: true, count: entries.length });
  }
  const roll = String(body.roll ?? "").trim();
  const student = body.student;
  if (!roll || !student || typeof student !== "object" || Array.isArray(student)) return NextResponse.json({ error: "Provide complete class data or a roll and student record." }, { status: 400 });
  data[roll] = { ...student, Roll: roll };
  await writeResults(classNo, data);
  return NextResponse.json({ ok: true, count: Object.keys(data).length });
}
