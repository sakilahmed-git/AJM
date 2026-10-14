import { NextResponse } from "next/server";
import fs from "node:fs/promises";
import path from "node:path";
import { readFeeCsv } from "@/lib/school-data";
export const dynamic="force-dynamic";
export async function GET(request:Request){
 const url=new URL(request.url),section=url.searchParams.get("section"),className=url.searchParams.get("class");
 if(!["exam_data","fees_data"].includes(section||"")||!className||!/^class([1-9]|10)$/.test(className))return NextResponse.json({error:"Choose a valid school data section and class."},{status:400});
 if(section==="fees_data")return NextResponse.json({class:className,section,content:await readFeeCsv(className.replace("class",""))},{headers:{"Cache-Control":"no-store"}});
 const file=path.join(process.cwd(),"data","exam_data",className+"_exams.csv");
 try{return NextResponse.json({class:className,section,content:await fs.readFile(file,"utf8")},{headers:{"Cache-Control":"no-store"}})}
 catch{return NextResponse.json({class:className,section,content:"Subject,Date,Time\n"},{headers:{"Cache-Control":"no-store"}})}
}
