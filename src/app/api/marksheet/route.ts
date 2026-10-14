import { NextResponse } from "next/server";
import { readResults, validClass } from "@/lib/school-data";
export async function POST(req:Request){
 const body=await req.json().catch(()=>({}));
 const classNo=String(body.class||""),roll=String(body.roll||"").trim(),dob=String(body.dob||"").trim();
 if(!validClass(classNo)||!roll||!dob)return NextResponse.json({error:"Enter class, roll number and date of birth."},{status:400});
 const data=await readResults(classNo);const student=data[roll];
 if(!student)return NextResponse.json({error:"No marksheet found for this class and roll number."},{status:404});
 const stored=String(student.DOB||"").trim();
 if(!stored||stored!==dob)return NextResponse.json({error:"The date of birth does not match our records."},{status:403});
 // DOB is used for verification only and is not included in the returned marksheet payload.
 const safe={...student};delete safe.DOB;delete safe.Admission;
 return NextResponse.json({student:safe,class:classNo,roll},{headers:{"Cache-Control":"no-store"}});
}
