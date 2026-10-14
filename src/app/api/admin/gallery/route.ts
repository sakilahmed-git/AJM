import { NextResponse } from "next/server";
import fs from "node:fs/promises";
import path from "node:path";
import { randomUUID } from "node:crypto";
import { isAdmin } from "@/lib/admin-auth";
const root=()=>path.join(process.cwd(),"public","uploads");
const allowed:Record<string,string>={"image/jpeg":".jpg","image/png":".png","image/webp":".webp","image/gif":".gif"};
const safeName=(n:string)=>n===path.basename(n)&&!n.includes("..")&&n.length<=220&&/\.(jpg|jpeg|png|webp|gif)$/i.test(n)&&!/[<>:"|?*\\\\/]/.test(n);
export async function GET(){
 if(!await isAdmin())return NextResponse.json({error:"Unauthorized"},{status:401});
 await fs.mkdir(root(),{recursive:true});
 const entries=await fs.readdir(root(),{withFileTypes:true});
 const items=await Promise.all(entries.filter(e=>e.isFile()&&safeName(e.name)).map(async e=>{const s=await fs.stat(path.join(root(),e.name));return{name:e.name,url:"/uploads/"+encodeURIComponent(e.name),size:s.size,modified:s.mtime.toISOString()}}));
 items.sort((a,b)=>b.modified.localeCompare(a.modified));
 return NextResponse.json({items},{headers:{"Cache-Control":"no-store"}});
}
export async function POST(req:Request){
 if(!await isAdmin())return NextResponse.json({error:"Unauthorized"},{status:401});
 const form=await req.formData(); const files=form.getAll("files").filter((f):f is File=>f instanceof File);
 if(!files.length)return NextResponse.json({error:"Choose at least one image."},{status:400});
 if(files.length>20)return NextResponse.json({error:"Upload up to 20 images at a time."},{status:400});
 await fs.mkdir(root(),{recursive:true}); const saved:string[]=[];
 for(const f of files){
  const ext=allowed[f.type]; if(!ext)return NextResponse.json({error:`Unsupported image type: ${f.name}`},{status:400});
  if(f.size>8*1024*1024)return NextResponse.json({error:`${f.name} exceeds 8 MB.`},{status:400});
  const base=f.name.replace(/\.[^.]+$/,"").normalize("NFKD").replace(/[^a-zA-Z0-9_-]+/g,"-").replace(/^-+|-+$/g,"").slice(0,60)||"school-image";
  const name=`${base}-${randomUUID().slice(0,8)}${ext}`;
  await fs.writeFile(path.join(root(),name),Buffer.from(await f.arrayBuffer()),{flag:"wx"});saved.push(name);
 }
 return NextResponse.json({ok:true,saved});
}
export async function DELETE(req:Request){
 if(!await isAdmin())return NextResponse.json({error:"Unauthorized"},{status:401});
 const name=new URL(req.url).searchParams.get("name")||""; if(!safeName(name))return NextResponse.json({error:"Invalid image name."},{status:400});
 try{await fs.unlink(path.join(root(),name));return NextResponse.json({ok:true})}catch{return NextResponse.json({error:"Image not found."},{status:404})}
}
