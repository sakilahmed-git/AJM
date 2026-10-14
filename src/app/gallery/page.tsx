"use client";
import { useEffect, useState } from "react";
import { Images, ArrowUpRight } from "lucide-react";
type Item={name:string;url:string;modified:string};
export default function GalleryPage(){
 const [items,setItems]=useState<Item[]>([]),[loading,setLoading]=useState(true);
 useEffect(()=>{fetch("/api/gallery",{cache:"no-store"}).then(r=>r.json()).then(d=>setItems(d.items||[])).catch(()=>setItems([])).finally(()=>setLoading(false))},[]);
 return <><main className="subpage"><div className="subpage-hero"><div className="subpage-copy"><div className="eyebrow"><span className="eyebrow-line"/> SCHOOL LIFE, IN FRAMES</div><h1>A little look <em>around.</em></h1><p>The everyday moments that make a school: learning, friendships, celebrations and people who help us grow.</p><a className="underlined-link" href="/#contact">Share a school moment <ArrowUpRight size={15}/></a></div><div className="subpage-symbol"><Images size={68} strokeWidth={1}/><span>AJM / SCHOOL LIFE</span></div></div>
 {loading?<p className="gallery-loading">Loading school moments…</p>:items.length?<div className="gallery-grid">{items.map((item,i)=><a className="gallery-item" href={item.url} target="_blank" rel="noreferrer" key={item.name}><img src={item.url} alt={`AJM English School — ${item.name}`} loading="lazy"/><span>AJM MOMENTS / {String(i+1).padStart(2,"0")}</span></a>)}</div>:<div className="gallery-empty"><Images size={34}/><h2>School moments are coming soon.</h2><p>New photos will appear here after they are uploaded by the school.</p></div>}
 <section className="subpage-help"><div><span className="section-kicker">WE’RE HERE TO HELP</span><h2>Need a little <em>guidance?</em></h2></div><a className="button button-dark" href="/#contact">Contact the school <ArrowUpRight size={16}/></a></section></main></>
}
