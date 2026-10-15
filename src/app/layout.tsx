import type { Metadata } from "next";
import "./globals.css";
import { SiteHeader, SiteFooter } from "@/components/site-shell";
import { MotionShell } from "@/components/motion-shell";
import { Analytics } from "@vercel/analytics/next";

export const metadata: Metadata = {
  title: {
    default: "AJM English School | Learn with Purpose",
    template: "%s | AJM English School",
  },
  description:
    "AJM English School, Gossaigaon, Assam — a caring learning community built on curiosity, confidence and character.",
  metadataBase: new URL("https://ajmenglishschool.in"),
  icons: { icon: ["/favicon.ico", "/favicon.png"], apple: "/favicon.png" },
  openGraph: {
    title: "AJM English School",
    description: "A place to grow, discover and become.",
    type: "website",
  },
};

export default function RootLayout({
  children,
}: Readonly<{ children: React.ReactNode }>) {
  return (
    <html lang="en">
      <body>
        {/* The only site-wide header/footer. Do not render these again in page layouts. */}
        <MotionShell>
          <SiteHeader />
          <main id="main-content">{children}</main>
          <SiteFooter />
        </MotionShell>
        <Analytics />
      </body>
    </html>
  );
}
