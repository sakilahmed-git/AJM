"use client";

import Link from "next/link";
import { useState, useEffect } from "react";
import { usePathname } from "next/navigation";
import { Menu, X, ArrowUpRight, MapPin, Mail, Phone } from "lucide-react";

const links = [
  ["Our School", "/#story"],
  ["Academics", "/academics"],
  ["Exam Dates", "/exam-dates"],
  ["Results", "/results"],
  ["Toppers", "/topper"],
  ["Fees", "/fees"],
  ["Gallery", "/gallery"],
] as const;

export function SiteHeader() {
  const [open, setOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const [hash, setHash] = useState("");
  const pathname = usePathname();

  useEffect(() => {
    const updateScroll = () => setScrolled(window.scrollY > 18);
    const updateHash = () => setHash(window.location.hash);
    updateScroll();
    updateHash();
    window.addEventListener("scroll", updateScroll, { passive: true });
    window.addEventListener("hashchange", updateHash);

    // Defensive cleanup for legacy pages that still render a second site header.
    const removeDuplicateHeaders = () => {
      const headers = Array.from(document.querySelectorAll<HTMLElement>(".site-header"));
      const primary = document.getElementById("ajm-site-header");
      headers.forEach((header) => {
        if (primary && header !== primary) header.remove();
      });
      // Older pages may render a second announcement outside their header.
      const announcements = Array.from(document.querySelectorAll<HTMLElement>(".announcement"));
      const primaryAnnouncement = primary?.querySelector<HTMLElement>(".announcement");
      announcements.forEach((item) => {
        if (primaryAnnouncement && item !== primaryAnnouncement) item.remove();
      });
    };
    removeDuplicateHeaders();
    const observer = new MutationObserver(removeDuplicateHeaders);
    observer.observe(document.body, { childList: true, subtree: true });

    return () => {
      window.removeEventListener("scroll", updateScroll);
      window.removeEventListener("hashchange", updateHash);
      observer.disconnect();
    };
  }, []);

  const isActive = (href: string) => {
    if (href === "/#story") return pathname === "/" && hash !== "#contact";
    if (href === "/#contact") return pathname === "/" && hash === "#contact";
    return pathname === href || (href !== "/" && pathname.startsWith(`${href}/`));
  };

  return (
    <header
      id="ajm-site-header"
      data-primary-site-header="true"
      className={`site-header site-header-sticky${scrolled ? " is-scrolled" : ""}`}
    >
      <div className="topline">
        <span>GOSSAIGAON, ASSAM</span>
        <span className="topline-note">A thoughtful education for a changing world</span>
        <a href="mailto:ajmschool@gmail.com">Get in touch <ArrowUpRight size={13} /></a>
      </div>
      <div className="nav-wrap">
        <Link className="brand" href="/" aria-label="AJM English School home" onClick={() => setOpen(false)}>
          <span className="brand-mark"><img src="/unnamed-fotor-bg-remover-20250627142251.png" alt="" /></span>
          <span className="brand-copy"><strong>AJM <i>English School</i></strong><small>LEARN · LEAD · BELONG</small></span>
        </Link>
        <button
          className="mobile-toggle"
          aria-label={open ? "Close navigation" : "Open navigation"}
          aria-expanded={open}
          onClick={() => setOpen((value) => !value)}
        >
          {open ? <X /> : <Menu />}
        </button>
        <nav className={open ? "nav-links is-open" : "nav-links"} aria-label="Main navigation">
          {links.map(([label, href]) => {
            const active = isActive(href);
            return (
              <Link key={label} href={href} onClick={() => setOpen(false)} className={active ? "nav-active" : undefined} aria-current={active ? "page" : undefined}>
                {label}
              </Link>
            );
          })}
          <Link className="nav-cta" href="/#contact" onClick={() => setOpen(false)}>Enquire <ArrowUpRight size={15} /></Link>
        </nav>
      </div>
      
      <style jsx global>{`
        #ajm-site-header.site-header-sticky {
          position: sticky !important;
          top: 0 !important;
          z-index: 10000 !important;
          width: 100%;
          display: block;
          isolation: isolate;
          align-self: start;
        }
        /* Hide legacy site-shell copies while retaining the one rendered by the root layout. */
        body .site-header:not(#ajm-site-header) { display: none !important; }
        #ajm-site-header .nav-links a {
          transition: color .22s ease, background-color .22s ease, transform .22s ease, box-shadow .22s ease;
        }
        #ajm-site-header .nav-links a:hover { transform: translateY(-1px); }
        #ajm-site-header .nav-links a.nav-active {
          color: #20513f;
          background: rgba(39, 91, 69, .10);
          border-radius: 9px;
          box-shadow: inset 0 -3px 0 #bd9a4c;
        }
        #ajm-site-header .brand img { display: block; }
        @media (max-width: 760px) {
          #ajm-site-header.site-header-sticky { top: 0 !important; }
        }
        @media (prefers-reduced-motion: reduce) {
          #ajm-site-header *, #ajm-site-header *::before, #ajm-site-header *::after {
            transition-duration: .01ms !important;
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            scroll-behavior: auto !important;
          }
        }
      `}</style>
    </header>
  );
}

export function SiteFooter() {
  return (
    <footer className="site-footer" id="contact">
      <div className="footer-main">
        <div className="footer-brand">
          <Link className="brand brand-light" href="/">
            <span className="brand-mark"><img src="/unnamed-fotor-bg-remover-20250627142251.png" alt="" /></span>
            <span className="brand-copy"><strong>AJM <i>English School</i></strong><small>LEARN · LEAD · BELONG</small></span>
          </Link>
          <p>Rooted in community. Open to possibility. Helping every student find the confidence to learn and the courage to lead.</p>
        </div>
        <div>
          <span className="footer-label">EXPLORE</span>
          <Link href="/academics">Academics</Link><Link href="/exam-dates">Exam dates</Link><Link href="/results">Student results</Link><Link href="/topper">Top achievers</Link><Link href="/fees">Fee portal</Link><Link href="/admin/login">Admin</Link><Link href="/gallery">School life</Link>
        </div>
        <div>
          <span className="footer-label">QUICK CONTACT</span>
          <p><MapPin size={15} /> Gossaigaon, Assam, India</p>
          <p><Mail size={15} /><a href="mailto:ajmschool@gmail.com">ajmschool@gmail.com</a></p>
          <p><Phone size={15} /><a href="tel:+919876543210">+91 98765 43210</a></p>
        </div>
      </div>
      <div className="footer-bottom"><span>© {new Date().getFullYear()} AJM English School</span><span>Built around the promise of every learner.</span><span>Privacy · Student-first always</span></div>
    </footer>
  );
}
