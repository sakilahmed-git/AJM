import fs from "node:fs/promises";
import path from "node:path";

const DATA_ROOT = path.join(process.cwd(), "data");
export const validClass = (value: string) => /^([1-9]|10)$/.test(value);
export function classFile(folder: "results_data" | "fees_data" | "exam_data", classNo: string, suffix = "") {
  if (!validClass(classNo)) throw new Error("Invalid class");
  return path.join(DATA_ROOT, folder, `class${classNo}${suffix}`);
}
export async function readResults(classNo: string): Promise<Record<string, Record<string, unknown>>> {
  const file = classFile("results_data", classNo, ".json");
  try {
    const parsed = JSON.parse(await fs.readFile(file, "utf8"));
    return parsed && typeof parsed === "object" && !Array.isArray(parsed) ? parsed : {};
  } catch (e) {
    if ((e as NodeJS.ErrnoException).code === "ENOENT") return {};
    throw e;
  }
}
export async function writeResults(classNo: string, data: Record<string, unknown>) {
  const file = classFile("results_data", classNo, ".json");
  await fs.mkdir(path.dirname(file), { recursive: true });
  const temp = `${file}.${process.pid}.tmp`;
  await fs.writeFile(temp, JSON.stringify(data, null, 2) + "\n", "utf8");
  await fs.rename(temp, file);
}
export async function readExamCsv(classNo: string) {
  const file = classFile("exam_data", classNo, "_exams.csv");
  try { return await fs.readFile(file, "utf8"); }
  catch (e) { if ((e as NodeJS.ErrnoException).code === "ENOENT") return "Subject,Date,Time\n"; throw e; }
}
export async function writeExamCsv(classNo: string, content: string) {
  const file = classFile("exam_data", classNo, "_exams.csv");
  await fs.mkdir(path.dirname(file), { recursive: true });
  await fs.writeFile(file, content, "utf8");
}
export async function readFeeCsv(classNo: string) {
  const file = classFile("fees_data", classNo, ".csv");
  try { return await fs.readFile(file, "utf8"); }
  catch (e) {
    if ((e as NodeJS.ErrnoException).code !== "ENOENT") throw e;
    const legacyFile = path.join(DATA_ROOT, "fees_data", `class-${classNo}-fees.csv`);
    try { return await fs.readFile(legacyFile, "utf8"); }
    catch (legacyError) { if ((legacyError as NodeJS.ErrnoException).code === "ENOENT") return "Roll,Name,DueAmount\n"; throw legacyError; }
  }
}
export async function writeFeeCsv(classNo: string, content: string) {
  let file = classFile("fees_data", classNo, ".csv");
  const legacyFile = path.join(DATA_ROOT, "fees_data", `class-${classNo}-fees.csv`);
  try { await fs.access(legacyFile); file = legacyFile; } catch { /* Use the current filename for new class files. */ }
  await fs.mkdir(path.dirname(file), { recursive: true });
  await fs.writeFile(file, content, "utf8");
}
export function csvRows(csv: string) {
  return csv.split(/\r?\n/).filter(Boolean).map(line => line.split(",").map(x => x.trim()));
}
