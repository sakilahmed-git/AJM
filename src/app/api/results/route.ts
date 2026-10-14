import { NextResponse } from "next/server";
import { readResults, validClass } from "@/lib/school-data";
export async function GET(request: Request) {
 const url=new URL(request.url),classNo=url.searchParams.get("class")??"",roll=(url.searchParams.get("roll")??"").trim();
 if(!validClass(classNo)||!roll)return NextResponse.json({error:"Choose a class and enter a roll number."},{status:400});
 const data=await readResults(classNo),student=data[roll];
 if(!student)return NextResponse.json({error:"No published result found for those details."},{status:404});
 const subjects=["English","Mathematics","Science","MIL","Social Science","Adv.Geography"];
 const subjectMarks=subjects.map(name=>({name,UT1:student[`${name} UT1`]??"",UT2:student[`${name} UT2`]??"",UT3:student[`${name} UT3`]??"",UT4:student[`${name} UT4`]??""})).filter(s=>[s.UT1,s.UT2,s.UT3,s.UT4].some(v=>v!==""&&v!==null&&v!==undefined));
 const safe={Name:student.Name,Class:classNo,Roll:student.Roll??roll,RankFinal:student.RankFinal,Remarks:student.Remarks,total1:student.total1,total2:student.total2,total3:student.total3,total4:student.total4,subjects:subjectMarks};
 return NextResponse.json({student:safe},{headers:{"Cache-Control":"no-store"}});
}
