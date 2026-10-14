import { NextResponse } from "next/server";
import fs from "node:fs/promises";
import path from "node:path";
import { isAdmin } from "@/lib/admin-auth";
export async function GET(){
 if(!await isAdmin())return NextResponse.json({error:"Unauthorized"},{status:401});
 const root=path.join(process.cwd(),"data");
 async function walk(dir:string):Promise<Record<string,string>>{
  const result:Record<string,string>={};
  for(const ent of await fs.readdir(dir,{withFileTypes:true})){
   const full=path.join(dir,ent.name);
   if(ent.isDirectory())Object.assign(result,await walk(full));
   else if(/\.(json|csv)$/i.test(ent.name)){const rel=path.relative(root,full).split(path.sep).join("/");result[rel]=await fs.readFile(full,"utf8");}
  }
  return result;
 }
 return new NextResponse(JSON.stringify({createdAt:new Date().toISOString(),files:await walk(root)},null,2),{headers:{"Content-Type":"application/json; charset=utf-8","Content-Disposition":`attachment; filename="ajm-school-data-backup-${new Date().toISOString().slice(0,10)}.json"`,"Cache-Control":"no-store"}});
}
