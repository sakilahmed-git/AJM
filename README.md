# AJM English School — full Next.js project

A premium Next.js 15 / React 19 / TypeScript school website and authenticated administration workspace.

## Run locally (Windows PowerShell)
```powershell
npm install
Copy-Item .env.example .env.local
# Edit .env.local and set a strong private password and a random ADMIN_SESSION_SECRET of at least 32 characters.
npm run dev
```
Open http://localhost:3000. Admin sign-in: http://localhost:3000/admin/login. Do not use the example credentials in production.

## Public website
- Premium homepage with school photos, animated hero, quick-access cards, campus, school values and contact section.
- Academics, exam dates, results, toppers, fees and gallery pages.
- Public results lookup by class and roll number.
- Marksheets at `/marksheet`, protected by class, roll number and date-of-birth verification. Use **Print / Save PDF** in the browser to save a PDF.
- Favicon and app icon generated from the school crest.

## Admin workspace
- Student directory and class selector (Classes 1–10).
- Select an existing student by roll/name; add, edit or delete student records.
- Edit admission, name, DOB, remarks, subject marks for UT1–UT4, unit totals and ranks.
- Totals automatically recalculate from six subjects for each unit test.
- Open the printable marksheet preview for a selected student.
- Bulk edit/inspect legacy student JSON for uncommon custom fields.
- Class-wise exam schedule CSV editor.
- Toppers publishing editor.
- Multi-image gallery uploads and delete controls.
- Class-wise fee CSV editor.
- Authenticated data backup download.

## Important data/security notes
- Private results, fee and exam data are stored in `data/`, not in `public/`.
- The public results endpoint returns an allow-list of result fields and never returns DOB or admission number.
- Marksheets require DOB verification. The DOB is not returned or printed.
- Admin APIs use an HTTP-only signed session cookie and require `ADMIN_SESSION_SECRET`.
- Uploaded gallery images are restricted by MIME type and file size. Review uploads before publication.
- Fee CSV editing is not payment processing. Do not accept real payments until a complete server-side payment provider flow, webhook verification, receipts and reconciliation are implemented.
- Data backups contain student data. Store them privately and do not commit them to Git.
- Before production, add rate limiting to login and marksheet verification, CSRF protections where applicable, and a database/transactional storage if multiple administrators will write concurrently.
- This project is a Next.js app and must be deployed to a compatible Node.js host, not as static PHP files.
- A framework rebuild does not automatically clear a Google Safe Browsing warning. Review Search Console Security Issues and hosting files before requesting a review.
