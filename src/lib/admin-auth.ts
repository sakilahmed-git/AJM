import { createHmac, timingSafeEqual } from "node:crypto";
import { cookies } from "next/headers";

const COOKIE = "ajm_admin_session";
function secret() {
  const s = process.env.ADMIN_SESSION_SECRET;
  if (!s || s.length < 32) throw new Error("ADMIN_SESSION_SECRET must be set to at least 32 characters.");
  return s;
}
function sign(value: string) {
  return createHmac("sha256", secret()).update(value).digest("hex");
}
export function createSessionToken() {
  const value = `${Date.now() + 8 * 60 * 60 * 1000}:admin`;
  return `${value}.${sign(value)}`;
}
export function isValidToken(token?: string) {
  if (!token) return false;
  const i = token.lastIndexOf(".");
  if (i < 1) return false;
  const value = token.slice(0, i);
  const signature = token.slice(i + 1);
  let expected: string;
  try { expected = sign(value); } catch { return false; }
  if (signature.length !== expected.length) return false;
  if (!timingSafeEqual(Buffer.from(signature), Buffer.from(expected))) return false;
  const [expiry, role] = value.split(":");
  return role === "admin" && Number(expiry) > Date.now();
}
export async function isAdmin() {
  const jar = await cookies();
  return isValidToken(jar.get(COOKIE)?.value);
}
export const sessionCookieName = COOKIE;
