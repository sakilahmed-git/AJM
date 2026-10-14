"use client";
import { useEffect, useState } from "react";
import { Trophy, Medal } from "lucide-react";

interface TopperStudent {
 name: string;
 rank: string;
 rankValue: number;
 marks?: string | number;
 percentage?: string | number;
 year?: string;
 image?: string;
}

interface TopperClass {
 class: number | string;
 students: TopperStudent[];
}

interface ToppersResponse {
 classes?: TopperClass[];
}

export default function TopperPage(){
 const [classes,setClasses]=useState<TopperClass[]>([]),[error,setError]=useState("");
 useEffect(()=>{fetch("/api/toppers",{cache:"no-store"}).then(r=>r.json()).then((d:ToppersResponse)=>setClasses(d.classes||[])).catch(()=>setError("Could not load topper data."))},[]);
 return <><main className="subpage"><div className="eyebrow"><span className="eyebrow-line"/> CELEBRATING ACHIEVEMENT</div><h1>Our <em>top achievers.</em></h1><p>Recognising students whose hard work and commitment deserve to be celebrated.</p>{error&&<p>{error}</p>}{classes.length===0&&!error&&<p className="topper-empty">No published topper records are available yet.</p>}<div className="topper-grid">{classes.map(group=><section className="topper-class" key={group.class}><div className="topper-class-head"><Trophy/><h2>Class {group.class}</h2><span>{group.students.length} achiever{group.students.length===1?"":"s"}</span></div>{group.students.map(s=><div className="topper-student" key={s.name+s.rank}>{s.image?<img className="topper-student-photo" src={s.image} alt="" loading="lazy"/>:<Medal/>}<div className="topper-student-copy"><strong>{s.name}</strong><small>{[s.percentage,s.marks,s.year].filter(Boolean).join(" · ")}</small></div><span>{s.rank}</span></div>)}</section>)}</div></main></>
}
