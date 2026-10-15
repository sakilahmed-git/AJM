
import { NextResponse } from "next/server";
import { readResults, validClass } from "@/lib/school-data";

function normalizeDob(value: string): string {
  const v = value.trim();

  // YYYY-MM-DD
  let match = v.match(/^(\d{4})-(\d{2})-(\d{2})$/);
  if (match) {
    return isValidDate(+match[1], +match[2], +match[3])
      ? `${match[1]}-${match[2]}-${match[3]}`
      : "";
  }

  // DD/MM/YYYY
  match = v.match(/^(\d{2})\/(\d{2})\/(\d{4})$/);
  if (match) {
    const [, day, month, year] = match;
    return isValidDate(+year, +month, +day)
      ? `${year}-${month}-${day}`
      : "";
  }

  // DD-MM-YYYY
  match = v.match(/^(\d{2})-(\d{2})-(\d{4})$/);
  if (match) {
    const [, day, month, year] = match;
    return isValidDate(+year, +month, +day)
      ? `${year}-${month}-${day}`
      : "";
  }

  return "";
}

function isValidDate(year: number, month: number, day: number): boolean {
  const date = new Date(Date.UTC(year, month - 1, day));

  return (
    date.getUTCFullYear() === year &&
    date.getUTCMonth() === month - 1 &&
    date.getUTCDate() === day
  );
}

export async function POST(req: Request) {
  try {
    const body = await req.json().catch(() => ({}));

    const classNo = String(body.class ?? "");
    const roll = String(body.roll ?? "").trim();
    const dob = normalizeDob(String(body.dob ?? ""));

    if (!validClass(classNo) || !roll || !dob) {
      return NextResponse.json(
        { error: "Enter a valid class, roll number and date of birth." },
        { status: 400 }
      );
    }

    const data = await readResults(classNo);
    const student = data[roll];

    if (!student) {
      return NextResponse.json(
        { error: "No marksheet found for this class and roll number." },
        { status: 404 }
      );
    }

    const storedDob = normalizeDob(String(student.DOB ?? ""));

    if (!storedDob || storedDob !== dob) {
      return NextResponse.json(
        { error: "The date of birth does not match our records." },
        { status: 403 }
      );
    }

    // Never expose DOB or admission information in the response.
    const safe = { ...student };
    delete safe.DOB;
    delete safe.Admission;

    return NextResponse.json(
      { student: safe, class: classNo, roll },
      {
        headers: {
          "Cache-Control": "no-store, private",
        },
      }
    );
  } catch {
    return NextResponse.json(
      { error: "Unable to retrieve the marksheet. Please try again." },
      { status: 500 }
    );
  }
}
