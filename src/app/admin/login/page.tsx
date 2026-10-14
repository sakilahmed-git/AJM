"use client";

import { useState } from "react";
import { LockKeyhole } from "lucide-react";
import { useRouter } from "next/navigation";

export default function AdminLogin() {
const [username, setUsername] = useState("");
const [password, setPassword] = useState("");
const [error, setError] = useState("");
const [busy, setBusy] = useState(false);
const router = useRouter();

async function submit(e: React.FormEvent<HTMLFormElement>) {
e.preventDefault();
setBusy(true);
setError("");

try {
  const response = await fetch("/api/admin/login", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ username, password }),
  });

  const data = await response.json();

  if (!response.ok) {
    throw new Error(data.error || "Login failed");
  }

  router.push("/admin");
  router.refresh();
} catch (error: unknown) {
  setError(
    error instanceof Error ? error.message : "Login failed"
  );
} finally {
  setBusy(false);
}

}

return (
<main className="subpage admin-login">
<div className="login-card">
<div className="login-icon">
<LockKeyhole />
</div>

    <div className="eyebrow">AJM / ADMINISTRATION</div>
    <h1>
      Welcome <em>back.</em>
    </h1>
    <p>Sign in to manage school records and published information.</p>

    <form onSubmit={submit}>
      <label>
        Username
        <input
          value={username}
          onChange={(e) => setUsername(e.target.value)}
          autoComplete="username"
          required
        />
      </label>

      <label>
        Password
        <input
          type="password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          autoComplete="current-password"
          required
        />
      </label>

      {error && (
        <p className="login-error" role="alert">
          {error}
        </p>
      )}

      <button className="button button-dark" disabled={busy}>
        {busy ? "Signing in…" : "Secure sign in"}
      </button>
    </form>
  </div>
</main>

);
}