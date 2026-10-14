"use client";
import { useEffect, useMemo, useState } from "react";
import { CalendarDays, ChevronLeft, ChevronRight, RefreshCw } from "lucide-react";
type Exam={date:string;subject:string;time?:string};
const classes=Array.from({length:10},(_,i)=>i+1);
function parseCsv(csv:string):Exam[]{
 const lines=csv.trim().split(/\r?\n/).filter(Boolean);if(lines.length<2)return[];
 const headers=lines.shift()!.split(",").map(s=>s.trim().toLowerCase());
 const pick=(row:string[],...keys:string[])=>{const i=headers.findIndex(h=>keys.includes(h));return i>=0?(row[i]??"").trim():""};
 return lines.map(line=>{const row=line.split(",").map(s=>s.trim());return{subject:pick(row,"subject","exam","name"),date:pick(row,"date","exam date"),time:pick(row,"time","start time","timing")}}).filter(e=>e.subject&&/^\d{4}-\d{2}-\d{2}$/.test(e.date));
}
export default function ExamCalendar(){
 const [selectedClass,setSelectedClass]=useState("1"),[month,setMonth]=useState(new Date().getMonth()),[year,setYear]=useState(new Date().getFullYear()),[exams,setExams]=useState<Exam[]>([]),[loading,setLoading]=useState(true),[error,setError]=useState("");
 useEffect(()=>{let alive=true;setLoading(true);setError("");fetch(`/api/school-data?section=exam_data&class=class${selectedClass}`,{cache:"no-store"}).then(async r=>{const d=await r.json();if(!r.ok)throw new Error(d.error||"Could not load timetable.");return d}).then(d=>{if(alive)setExams(parseCsv(d.content||""))}).catch(e=>{if(alive){setExams([]);setError(e instanceof Error?e.message:"Could not load timetable.")}}).finally(()=>{if(alive)setLoading(false)});return()=>{alive=false}},[selectedClass]);
 const monthName=new Date(year,month).toLocaleDateString("en-IN",{month:"long",year:"numeric"}),days=new Date(year,month+1,0).getDate(),offset=new Date(year,month,1).getDay();
 const monthExams=useMemo(()=>exams.filter(e=>{const d=new Date(`${e.date}T00:00:00`);return d.getFullYear()===year&&d.getMonth()===month}),[exams,year,month]);
 function changeMonth(direction:number){const next=new Date(year,month+direction,1);setMonth(next.getMonth());setYear(next.getFullYear())}
 return <section className="exam-calendar">
  <div className="exam-toolbar"><label>Select class<select value={selectedClass} onChange={e=>setSelectedClass(e.target.value)}>{classes.map(n=><option key={n} value={String(n)}>Class {n}</option>)}</select></label></div>
  <div className="calendar-panel"><div className="calendar-heading"><div><CalendarDays size={22}/><strong>{monthName}</strong></div><div className="calendar-controls"><button type="button" aria-label="Previous month" onClick={()=>changeMonth(-1)}><ChevronLeft size={18}/></button><button type="button" aria-label="Next month" onClick={()=>changeMonth(1)}><ChevronRight size={18}/></button></div></div>
   <div className="calendar-grid">{["Sun","Mon","Tue","Wed","Thu","Fri","Sat"].map(day=><div className="calendar-weekday" key={day}>{day}</div>)}{Array.from({length:offset},(_,i)=><div className="calendar-day empty" key={`empty-${i}`}/>)}{Array.from({length:days},(_,i)=>{const day=i+1,date=`${year}-${String(month+1).padStart(2,"0")}-${String(day).padStart(2,"0")}`,dayExams=monthExams.filter(e=>e.date===date);return <div className={`calendar-day ${dayExams.length?"has-exam":""}`} key={date}><span>{day}</span>{dayExams.map((exam,index)=><small key={`${exam.subject}-${index}`} title={`${exam.subject}${exam.time?` · ${exam.time}`:""}`}>{exam.subject}</small>)}</div>})}</div>
  </div>
  <div className="exam-list"><div className="ajm-exam-list-heading"><h3>Class {selectedClass} timetable</h3><span>{exams.length} scheduled exam{exams.length===1?"":"s"}</span></div>
   {loading?<div className="exam-empty"><RefreshCw size={25} className="ajm-spin"/><p>Loading published timetable…</p></div>:error?<div className="exam-empty"><CalendarDays size={30}/><h3>Could not load the schedule</h3><p>{error}</p></div>:monthExams.length?monthExams.slice().sort((a,b)=>a.date.localeCompare(b.date)).map((exam,i)=><article className="exam-row" key={`${exam.date}-${exam.subject}-${i}`}><div><strong>{exam.subject}</strong><span>{new Date(`${exam.date}T00:00:00`).toLocaleDateString("en-IN",{weekday:"long",day:"numeric",month:"short"})}</span></div><span>{exam.time||"Time to be confirmed"}</span></article>):<div className="exam-empty"><CalendarDays size={30}/><h3>{exams.length?"No exams in this month":"No timetable published yet"}</h3><p>{exams.length?"Use the calendar arrows to check another month.":"The school has not published exam dates for this class yet. Please check back later."}</p></div>}
  </div>
 </section>
}
