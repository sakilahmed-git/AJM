import { NextResponse } from "next/server";
import fs from "node:fs/promises";
import path from "node:path";
import { randomUUID } from "node:crypto";

type Application = {
  id: string; applicationNo: string; submittedAt: string; status: "pending" | "accepted" | "rejected";
  studentName: string; dob: string; gender: string; applyingClass: string; guardianName: string;
  phone: string; email: string; address: string; previousSchool: string; previousClass: string;
  notes: string; decisionAt?: string; decisionNote?: string; assignedRoll?: string; admissionNo?: string;
};
const file = () => path.join(process.cwd(), "data", "admissions", "applications.json");
async function readApplications(): Promise<Application[]> {
  try { const data = JSON.parse(await fs.readFile(file(), "utf8")); return Array.isArray(data) ? data : []; }
  catch (error) { if ((error as NodeJS.ErrnoException).code === "ENOENT") return []; throw error; }
}
async function writeApplications(data: Application[]) {
  const target = file(); await fs.mkdir(path.dirname(target), { recursive: true });
  const temp = `${target}.${process.pid}.tmp`;
  await fs.writeFile(temp, JSON.stringify(data, null, 2) + "\n", "utf8");
  await fs.rename(temp, target);
}
function clean(value: unknown, max = 300) { return String(value ?? "").trim().slice(0, max); }
function validClass(value: string) { return /^(1|2|3|4|5|6|7|8|9|10)$/.test(value); }

export async function POST(request: Request) {
  const body = await request.json().catch(() => null);
  if (!body || typeof body !== "object") return NextResponse.json({ error: "Invalid application." }, { status: 400 });
  const studentName = clean(body.studentName, 120), dob = clean(body.dob, 10), gender = clean(body.gender, 30);
  const applyingClass = clean(body.applyingClass, 2), guardianName = clean(body.guardianName, 120);
  const phone = clean(body.phone, 20), email = clean(body.email, 160), address = clean(body.address, 500);
  const previousSchool = clean(body.previousSchool, 180), previousClass = clean(body.previousClass, 50), notes = clean(body.notes, 1000);
  if (!studentName || !/^\d{4}-\d{2}-\d{2}$/.test(dob) || !validClass(applyingClass) || !guardianName || !/^\+?[0-9\s()-]{8,20}$/.test(phone) || !email.includes("@") || address.length < 8) {
    return NextResponse.json({ error: "Complete all required fields with a valid date of birth, class, guardian contact, email and address." }, { status: 400 });
  }
  try {
    const applications = await readApplications();
    const now = new Date();
    const year = now.getFullYear();
    const sequence = applications.filter(a => a.applicationNo.startsWith(`AJM-APP-${year}-`)).length + 1;
    const application: Application = {
      id: randomUUID(), applicationNo: `AJM-APP-${year}-${String(sequence).padStart(4, "0")}`,
      submittedAt: now.toISOString(), status: "pending", studentName, dob, gender, applyingClass,
      guardianName, phone, email, address, previousSchool, previousClass, notes,
    };
    applications.push(application);
    await writeApplications(applications);
    return NextResponse.json({ ok: true, applicationNo: application.applicationNo }, { status: 201, headers: { "Cache-Control": "no-store" } });
  } catch {
    return NextResponse.json({ error: "We could not submit the application right now. Please try again or contact the school." }, { status: 500 });
  }
}
