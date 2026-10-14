import { NextResponse } from "next/server";
import fs from "node:fs/promises";
import path from "node:path";
import { readResults } from "@/lib/school-data";
export async function GET() {
 const manualFile=path.join(process.cwd(),"data","topper_data","toppers.json");
 try {
  const manual=JSON.parse(await fs.readFile(manualFile,"utf8"));
  if(Array.isArray(manual)){
   const groups=new Map<string,{class:number|string;students:{name:string;rank:string;rankValue:number;marks?:string|number;percentage?:string|number;year?:string;image?:string}[]}>();
   for(const row of manual){
    if(!row||typeof row.name!=="string")continue;
    const classLabel=String(row.class??"School-wide");
    if(!groups.has(classLabel))groups.set(classLabel,{class:/^\d+$/.test(classLabel)?Number(classLabel):classLabel,students:[]});
    const group=groups.get(classLabel)!;
    group.students.push({name:row.name,rank:String(row.rank??`${group.students.length+1}`),rankValue:group.students.length+1,marks:row.marks,percentage:row.percentage,year:row.year,image:row.image});
   }
   return NextResponse.json({classes:Array.from(groups.values())},{headers:{"Cache-Control":"no-store"}});
  }
 } catch {}
 const ranks:Record<string,number>={"1st":1,"2nd":2,"3rd":3,"4th":4,"5th":5};
 const classes=[];
 for(let c=1;c<=10;c++){
  const data=await readResults(String(c));
  const students=Object.values(data).filter(s=>s&&ranks[String(s.Rank1??"")]).map(s=>({name:String(s.Name??"Student"),rank:String(s.Rank1),rankValue:ranks[String(s.Rank1)]})).sort((a,b)=>a.rankValue-b.rankValue);
  if(students.length)classes.push({class:c,students});
 }
 return NextResponse.json({classes},{headers:{"Cache-Control":"no-store"}});
}
