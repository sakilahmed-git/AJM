import { redirect } from "next/navigation";
import { isAdmin } from "@/lib/admin-auth";
import AdminWorkspace from "./AdminWorkspace";
export const dynamic = "force-dynamic";
export default async function AdminPage() {
  if (!await isAdmin()) redirect("/admin/login");
  return <AdminWorkspace />;
}
