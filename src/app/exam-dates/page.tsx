import InformationPage from "@/app/[slug]/page";
export default function Page() {
  return <InformationPage params={Promise.resolve({ slug: "exam-dates" })} />;
}
