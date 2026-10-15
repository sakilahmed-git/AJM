
"use client";

import Link from "next/link";
import { type FormEvent, useEffect, useState } from "react";
import {
  Printer,
  ShieldCheck,
  GraduationCap,
  ArrowLeft,
  AlertCircle,
  LoaderCircle,
} from "lucide-react";

type Student = Record<string, unknown>;

const subjects = [
  "English",
  "Mathematics",
  "Science",
  "MIL",
  "Social Science",
  "Adv.Geography",
];

export default function MarksheetPage() {
  const [classNo, setClassNo] = useState("10");
  const [roll, setRoll] = useState("");
  const [dob, setDob] = useState("");
  const [student, setStudent] = useState<Student | null>(null);
  const [error, setError] = useState("");
  const [busy, setBusy] = useState(false);

  useEffect(() => {
    const params = new URLSearchParams(window.location.search);
    const queryClass = params.get("class");
    const queryRoll = params.get("roll");

    if (queryClass) setClassNo(queryClass);
    if (queryRoll) setRoll(queryRoll);
  }, []);

  const display = (value: unknown) =>
    value === undefined || value === null || value === ""
      ? "—"
      : String(value);

  async function submit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();

    if (busy) return;

    setBusy(true);
    setError("");
    setStudent(null);

    try {
      const response = await fetch("/api/marksheet", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        cache: "no-store",
        body: JSON.stringify({
          class: classNo,
          roll: roll.trim(),
          dob,
        }),
      });

      const data = await response.json();

      if (!response.ok) {
        throw new Error(
          data.error || "Unable to retrieve the marksheet."
        );
      }

      if (!data.student || typeof data.student !== "object") {
        throw new Error("The server returned an invalid student record.");
      }

      setStudent(data.student as Student);
    } catch (err) {
      setError(
        err instanceof Error
          ? err.message
          : "Something went wrong. Please try again."
      );
    } finally {
      setBusy(false);
    }
  }

  function printMarksheet() {
    window.print();
  }

  return (
    <main className="ajm-marksheet-page">
      <div className="ajm-marksheet-toolbar">
        <Link href="/results">
          <ArrowLeft size={16} />
          Back to results
        </Link>

        {student && (
          <button type="button" onClick={printMarksheet}>
            <Printer size={16} />
            Print / Save PDF
          </button>
        )}
      </div>

      {error && (
        <div
          className="ajm-ms-error"
          role="alert"
          style={{
            maxWidth: 680,
            margin: "16px auto",
            display: "flex",
            alignItems: "center",
            gap: 10,
          }}
        >
          <AlertCircle size={18} />
          <span>{error}</span>
        </div>
      )}

      {!student ? (
        <section className="ajm-marksheet-gate">
          <div className="ajm-ms-crest">
            <GraduationCap size={32} />
          </div>

          <span className="ajm-admin-eyebrow">
            SECURE ACADEMIC RECORDS
          </span>

          <h1>
            Your marksheet,
            <br />
            <em>made accessible.</em>
          </h1>

          <p>
            Verify your class, roll number and date of birth to
            retrieve your student marksheet.
          </p>

          <form onSubmit={submit}>
            <label>
              Class
              <select
                value={classNo}
                onChange={(event) => setClassNo(event.target.value)}
                required
              >
                {Array.from({ length: 10 }, (_, index) => (
                  <option key={index} value={String(index + 1)}>
                    Class {index + 1}
                  </option>
                ))}
              </select>
            </label>

            <label>
              Roll number
              <input
                type="text"
                value={roll}
                onChange={(event) => setRoll(event.target.value)}
                required
                placeholder="Enter your roll number"
                autoComplete="off"
              />
            </label>

            <label>
              Date of birth
              <input
                type="date"
                value={dob}
                onChange={(event) => setDob(event.target.value)}
                required
                autoComplete="bday"
              />
            </label>

            <button
              className="ajm-ms-submit"
              type="submit"
              disabled={busy}
            >
              {busy ? (
                <>
                  <LoaderCircle
                    size={17}
                    style={{ animation: "ajm-ms-spin 1s linear infinite" }}
                  />
                  Verifying record…
                </>
              ) : (
                <>
                  Verify &amp; view marksheet
                  <ShieldCheck size={17} />
                </>
              )}
            </button>
          </form>

          <small className="ajm-ms-privacy">
            <ShieldCheck size={14} />
            Your date of birth is used for verification and is not
            printed on the marksheet.
          </small>
        </section>
      ) : (
        <section
          className="ajm-print-sheet"
          style={{
            display: "block",
            visibility: "visible",
            opacity: 1,
            position: "relative",
            color: "#202820",
            background: "#fff",
            width: "100%",
            boxSizing: "border-box",
            minWidth: 0,
            zIndex: 1,
          }}
        >
          <header className="ajm-print-header">
            <img
              src="/unnamed-fotor-bg-remover-20250627142251.png"
              alt="AJM English School crest"
            />

            <div>
              <span>GOSSAIGAON, ASSAM</span>
              <h1>AJM English School</h1>
              <p>STUDENT ACADEMIC REPORT</p>
            </div>

            <div className="ajm-print-year">
              ACADEMIC
              <br />
              <b>RECORD</b>
            </div>
          </header>

          <div className="ajm-print-title">
            <span>STUDENT MARKSHEET</span>
            <h2>Statement of examination performance</h2>
            <p>Keep this document for your academic records.</p>
          </div>

          <div className="ajm-print-student">
            <div>
              <small>STUDENT NAME</small>
              <b>{display(student.Name)}</b>
            </div>

            <div>
              <small>CLASS</small>
              <b>{display(student.Class ?? classNo)}</b>
            </div>

            <div>
              <small>ROLL NUMBER</small>
              <b>{display(student.Roll ?? roll)}</b>
            </div>

            <div>
              <small>FINAL RANK</small>
              <b>{display(student.RankFinal)}</b>
            </div>
          </div>

          <div className="ajm-print-table-wrap">
            <table>
              <thead>
                <tr>
                  <th>Subject</th>
                  <th>UT 1</th>
                  <th>UT 2</th>
                  <th>UT 3</th>
                  <th>UT 4</th>
                  <th>Total</th>
                </tr>
              </thead>

              <tbody>
                {subjects.map((subject) => {
                  const keys = [1, 2, 3, 4].map(
                    (test) => `${subject} UT${test}`
                  );

                  const present = keys.some(
                    (key) =>
                      student[key] !== undefined &&
                      student[key] !== null &&
                      student[key] !== ""
                  );

                  if (!present) return null;

                  const values = keys.map((key) => {
                    const value = student[key];
                    return value === undefined ||
                      value === null ||
                      value === ""
                      ? null
                      : Number(value);
                  });

                  const total = values.reduce<number>(
                    (sum, value) =>
                      sum + (value !== null && Number.isFinite(value) ? value : 0),
                    0
                  );

                  return (
                    <tr key={subject}>
                      <td>{subject}</td>
                      {values.map((value, index) => (
                        <td key={index}>
                          {value === null ? "—" : value}
                        </td>
                      ))}
                      <td>{total}</td>
                    </tr>
                  );
                })}

                <tr className="ajm-print-total">
                  <td>Examination totals</td>
                  {[1, 2, 3, 4].map((test) => (
                    <td key={test}>{display(student[`total${test}`])}</td>
                  ))}
                  <td>
                    {[1, 2, 3, 4].reduce((sum, test) => {
                      const value = Number(student[`total${test}`]);
                      return sum + (Number.isFinite(value) ? value : 0);
                    }, 0)}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div className="ajm-print-notes">
            <div>
              <small>REMARKS</small>
              <p>{display(student.Remarks)}</p>
            </div>

            <div className="ajm-print-sign">
              <img src="/sign.jpg" alt="School signature" />
              <span>Authorised signatory</span>
            </div>
          </div>

          <footer className="ajm-print-footer">
            <span>AJM ENGLISH SCHOOL · LEARN · LEAD · BELONG</span>
            <span>Student record retrieved after credential verification</span>
          </footer>
        </section>
      )}

      <style jsx>{`
        @keyframes ajm-ms-spin {
          to {
            transform: rotate(360deg);
          }
        }

        .ajm-ms-submit:disabled {
          cursor: wait;
          opacity: 0.75;
        }

        .ajm-ms-submit {
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 10px;
        }

        @media print {
          @page {
            size: A4 landscape;
            margin: 8mm;
          }

          :global(html),
          :global(body) {
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
          }

          body * {
            visibility: hidden !important;
          }

          .ajm-print-sheet,
          .ajm-print-sheet * {
            visibility: visible !important;
          }

          .ajm-print-sheet {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 0 !important;
            border: 0 !important;
            box-shadow: none !important;
            background: #fff !important;
            zoom: 0.85;
            break-inside: avoid !important;
            page-break-inside: avoid !important;
          }

          .ajm-marksheet-toolbar,
          .ajm-marksheet-gate {
            display: none !important;
          }

          .ajm-print-sheet table {
            width: 100% !important;
            table-layout: fixed !important;
            border-collapse: collapse !important;
          }

          .ajm-print-header,
          .ajm-print-title,
          .ajm-print-student,
          .ajm-print-notes,
          .ajm-print-footer,
          .ajm-print-sheet tr {
            break-inside: avoid !important;
            page-break-inside: avoid !important;
          }
        }
      `}</style>
    </main>
  );
}
