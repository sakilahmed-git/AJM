"use client";
import { useState, type FormEvent } from "react";
import { ArrowUpRight, CheckCircle2, GraduationCap, ShieldCheck, AlertCircle } from "lucide-react";
const initial = { studentName: "", dob: "", gender: "", applyingClass: "1", guardianName: "", phone: "", email: "", address: "", previousSchool: "", previousClass: "", notes: "" };
export default function AdmissionsPage() {
  const [form, setForm] = useState(initial);
  const [busy, setBusy] = useState(false);
  const [error, setError] = useState("");
  const [applicationNo, setApplicationNo] = useState("");
  async function submit(e: FormEvent<HTMLFormElement>) {
    e.preventDefault(); setBusy(true); setError("");
    try {
      const response = await fetch("/api/admissions", { method: "POST", headers: { "Content-Type": "application/json" }, body: JSON.stringify(form) });
      const data = await response.json();
      if (!response.ok) throw new Error(data.error || "Application could not be submitted.");
      setApplicationNo(data.applicationNo); setForm(initial); window.scrollTo({ top: 0, behavior: "smooth" });
    } catch (e) { setError(e instanceof Error ? e.message : "Please try again."); }
    finally { setBusy(false); }
  }
  const set = (key: keyof typeof initial, value: string) => setForm(v => ({ ...v, [key]: value }));
  return <main className="subpage ajm-admissions-page">
    <section className="subpage-hero">
      <div className="subpage-copy"><div className="eyebrow"><span className="eyebrow-line"/> JOIN OUR SCHOOL</div><h1>Every journey<br/><em>starts here.</em></h1><p>Apply online to AJM English School. Submit the student's details and our school team will review the application.</p><a className="underlined-link" href="/#contact">Questions? Contact the school <ArrowUpRight size={15}/></a></div>
      <div className="subpage-symbol"><GraduationCap size={68} strokeWidth={1}/><span>AJM / ADMISSIONS</span></div>
    </section>
    {applicationNo ? <section className="ajm-admission-success"><CheckCircle2 size={36}/><span className="section-kicker">APPLICATION SUBMITTED</span><h2>Thank you for applying.</h2><p>Your application has been received and is awaiting school review. Keep this reference number for your records.</p><strong>{applicationNo}</strong><button className="button button-dark" onClick={() => { setApplicationNo(""); setForm(initial); }}>Submit another application</button></section> : <section className="ajm-admission-form-section">
      <div className="ajm-admission-form-heading"><span className="section-kicker">ONLINE ADMISSION FORM</span><h2>Tell us about your <em>student.</em></h2><p>Fields marked * are required. The school will contact the parent or guardian about the application.</p></div>
      <form className="ajm-admission-form" onSubmit={submit}>
        <div className="ajm-admission-form-group"><h3>01 <span>Student details</span></h3><div className="ajm-admission-fields">
          <label>Student's full name *<input required maxLength={120} value={form.studentName} onChange={e=>set("studentName",e.target.value)} autoComplete="name"/></label>
          <label>Date of birth *<input required type="date" max={new Date().toISOString().slice(0,10)} value={form.dob} onChange={e=>set("dob",e.target.value)}/></label>
          <label>Gender<select value={form.gender} onChange={e=>set("gender",e.target.value)}><option value="">Select if applicable</option><option>Female</option><option>Male</option><option>Prefer not to say</option></select></label>
          <label>Applying for class *<select required value={form.applyingClass} onChange={e=>set("applyingClass",e.target.value)}>{Array.from({length:10},(_,i)=><option key={i} value={String(i+1)}>Class {i+1}</option>)}</select></label>
          <label>Previous school<input maxLength={180} value={form.previousSchool} onChange={e=>set("previousSchool",e.target.value)}/></label>
          <label>Previous class<input maxLength={50} value={form.previousClass} onChange={e=>set("previousClass",e.target.value)} placeholder="e.g. Class 4"/></label>
        </div></div>
        <div className="ajm-admission-form-group"><h3>02 <span>Parent / guardian</span></h3><div className="ajm-admission-fields">
          <label>Parent or guardian's name *<input required maxLength={120} value={form.guardianName} onChange={e=>set("guardianName",e.target.value)} autoComplete="name"/></label>
          <label>Phone number *<input required type="tel" minLength={8} maxLength={20} value={form.phone} onChange={e=>set("phone",e.target.value)} autoComplete="tel"/></label>
          <label>Email address *<input required type="email" maxLength={160} value={form.email} onChange={e=>set("email",e.target.value)} autoComplete="email"/></label>
          <label className="ajm-admission-wide">Residential address *<textarea required minLength={8} maxLength={500} rows={3} value={form.address} onChange={e=>set("address",e.target.value)} autoComplete="street-address"/></label>
          <label className="ajm-admission-wide">Additional information<textarea maxLength={1000} rows={3} value={form.notes} onChange={e=>set("notes",e.target.value)} placeholder="Anything the school should know (optional)"/></label>
        </div></div>
        {error && <div className="ajm-admission-error"><AlertCircle size={17}/>{error}</div>}
        <div className="ajm-admission-submit-row"><p><ShieldCheck size={16}/> Your details are submitted securely for school review. Submission does not guarantee admission.</p><button className="button button-dark" disabled={busy}>{busy ? "Submitting…" : "Submit application"} <ArrowUpRight size={16}/></button></div>
      </form>
    </section>}
  </main>;
}
