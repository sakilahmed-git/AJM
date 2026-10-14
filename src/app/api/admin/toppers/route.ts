import { NextResponse } from "next/server";
import fs from "node:fs/promises";
import path from "node:path";
import { isAdmin } from "@/lib/admin-auth";
const file = () => path.join(process.cwd(), "data", "topper_data", "toppers.json");
async function read() { try { const v=JSON.parse(await fs.readFile(file(),"utf8")); return Array.isArray(v)?v:[]; } catch(e) { if((e as NodeJS.ErrnoException).code==="ENOENT") return []; throw e; } }
export async function GET() {
 if(!await isAdmin()) return NextResponse.json({error:"Unauthorized"},{status:401});
 try{return NextResponse.json({data:await read()},{headers:{"Cache-Control":"no-store"}})}catch{return NextResponse.json({error:"Could not read toppers file."},{status:500})}
}
export async function PUT(req:Request) {
 if(!await isAdmin()) return NextResponse.json({error:"Unauthorized"},{status:401});
 const body=await req.json().catch(()=>({}));
 if(!Array.isArray(body.data)||body.data.length>500||body.data.some((x:unknown)=>!x||typeof x!=="object"||Array.isArray(x)||typeof (x as {name?:unknown}).name!=="string")) return NextResponse.json({error:"Toppers must be an array of objects, each with a name."},{status:400});
 const p=file(); await fs.mkdir(path.dirname(p),{recursive:true}); const tmp=p+".tmp"; await fs.writeFile(tmp,JSON.stringify(body.data,null,2)+"\n","utf8"); await fs.rename(tmp,p);
 return NextResponse.json({ok:true,count:body.data.length});
}
