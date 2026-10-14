import { NextResponse } from "next/server";
import { isAdmin } from "@/lib/admin-auth";
import { readFeeCsv, writeFeeCsv, validClass } from "@/lib/school-data";
export async function GET(req:Request){
 if(!await isAdmin())return NextResponse.json({error:"Unauthorized"},{status:401});
 const c=new URL(req.url).searchParams.get("class")||"";if(!validClass(c))return NextResponse.json({error:"Invalid class."},{status:400});
 try{return NextResponse.json({content:await readFeeCsv(c)},{headers:{"Cache-Control":"no-store"}})}catch{return NextResponse.json({error:"Could not read fee data."},{status:500})}
}
export async function PUT(req:Request){
 if(!await isAdmin())return NextResponse.json({error:"Unauthorized"},{status:401});
 const b=await req.json().catch(()=>({}));const c=String(b.class||""),content=String(b.content||"");
 if(!validClass(c)||content.length>200000)return NextResponse.json({error:"Invalid class or fee file too large."},{status:400});
 await writeFeeCsv(c,content);return NextResponse.json({ok:true});
}
