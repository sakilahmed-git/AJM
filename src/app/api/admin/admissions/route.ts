import { NextResponse } from "next/server";
import fs from "node:fs/promises";
import path from "node:path";
import { isAdmin } from "@/lib/admin-auth";
import { readResults, writeResults, validClass } from "@/lib/school-data";

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
  await fs.writeFile(temp, JSON.stringify(data, null, 2) + "\n", "utf8"); await fs.rename(temp, target);
}
export async function GET() {
  if (!await isAdmin()) return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  try {
    const applications = await readApplications();
    return NextResponse.json({ applications: applications.sort((a,b) => b.submittedAt.localeCompare(a.submittedAt)) }, { headers: { "Cache-Control": "no-store" } });
  } catch { return NextResponse.json({ error: "Could not load admission applications." }, { status: 500 }); }
}
export async function PUT(request: Request) {
  if (!await isAdmin()) return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  const body = await request.json().catch(() => ({}));
  const id = String(body.id ?? ""), action = String(body.action ?? ""), decisionNote = String(body.decisionNote ?? "").trim().slice(0, 1000);
  if (!id || !["accept", "reject"].includes(action)) return NextResponse.json({ error: "Choose an application and an accept/reject action." }, { status: 400 });
  try {
    const applications = await readApplications();
    const index = applications.findIndex(a => a.id === id);
    if (index < 0) return NextResponse.json({ error: "Application not found." }, { status: 404 });
    const application = applications[index];
    if (application.status !== "pending") return NextResponse.json({ error: `This application has already been ${application.status}.` }, { status: 409 });
    if (action === "reject") {
      applications[index] = { ...application, status: "rejected", decisionAt: new Date().toISOString(), decisionNote };
      await writeApplications(applications);
      return NextResponse.json({ ok: true, status: "rejected" });
    }
    const classNo = String(body.classNo ?? application.applyingClass);
    if (!validClass(classNo)) return NextResponse.json({ error: "Choose a valid class from 1 to 10." }, { status: 400 });
    const students = await readResults(classNo);
    const numericRolls = Object.keys(students).map(key => Number(key)).filter(Number.isSafeInteger).filter(n => n > 0);
    let rollNumber = String(Math.max(0, ...numericRolls) + 1);
    while (students[rollNumber]) rollNumber = String(Number(rollNumber) + 1);
    const year = new Date().getFullYear();
    const acceptedCount = applications.filter(a => a.status === "accepted" && a.admissionNo?.startsWith(`AJM-${year}-`)).length;
    const admissionNo = `AJM-${year}-${String(acceptedCount + 1).padStart(4, "0")}`;
    const dobParts = application.dob.split("-");
    const dobForLegacy = dobParts.length === 3 ? `${dobParts[2]}/${dobParts[1]}/${dobParts[0]}` : application.dob;
    const student: Record<string, unknown> = {
      Admission: admissionNo, Roll: rollNumber, Name: application.studentName, Class: classNo,
      DOB: dobForLegacy, Gender: application.gender, GuardianName: application.guardianName,
      GuardianPhone: application.phone, GuardianEmail: application.email, Address: application.address,
      PreviousSchool: application.previousSchool, PreviousClass: application.previousClass,
      Remarks: "Admitted through online application", ...Object.fromEntries(
        ["English", "Mathematics", "Science", "MIL", "Social Science", "Adv.Geography"].flatMap(subject => [1,2,3,4].map(ut => [`${subject} UT${ut}`, 0]))
      ), total1: 0, total2: 0, total3: 0, total4: 0, Rank1: "", Rank2: "", Rank3: "", Rank4: "", RankFinal: "",
    };
    students[rollNumber] = student;
    await writeResults(classNo, students);
    applications[index] = { ...application, status: "accepted", decisionAt: new Date().toISOString(), decisionNote, assignedRoll: rollNumber, admissionNo, applyingClass: classNo };
    await writeApplications(applications);
    return NextResponse.json({ ok: true, status: "accepted", student: { class: classNo, roll: rollNumber, admissionNo, name: application.studentName } });
  } catch {
    return NextResponse.json({ error: "Could not process this decision. Check the class data and try again." }, { status: 500 });
  }
}
