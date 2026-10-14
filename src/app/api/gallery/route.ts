import { NextResponse } from "next/server";
import fs from "node:fs/promises";
import path from "node:path";
export const dynamic="force-dynamic";
export async function GET(){
 const root=path.join(process.cwd(),"public","uploads");await fs.mkdir(root,{recursive:true});
 const entries=await fs.readdir(root,{withFileTypes:true});
 const items=await Promise.all(entries.filter(e=>e.isFile()&&/\.(jpe?g|png|webp|gif)$/i.test(e.name)).map(async e=>({name:e.name,url:"/uploads/"+encodeURIComponent(e.name),modified:(await fs.stat(path.join(root,e.name))).mtime.toISOString()})));
 items.sort((a,b)=>b.modified.localeCompare(a.modified));
 return NextResponse.json({items},{headers:{"Cache-Control":"no-store"}});
}
