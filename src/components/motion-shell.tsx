"use client";

import { useEffect, useRef, useState } from "react";
import { usePathname } from "next/navigation";

/** Shared, progressively-enhanced motion for every public and portal page. */
export function MotionShell({ children }: { children: React.ReactNode }) {
  const pathname = usePathname();
  const [navigating, setNavigating] = useState(false);
  const navigationTimeout = useRef<number | null>(null);

  useEffect(() => {
    const selectors = [
      ".subpage-hero", ".subpage-help", ".portal-form", ".portal-result",
      ".gallery-grid", ".gallery-item", ".gallery-empty", ".fee-cards article",
      ".fee-help", ".topper-class", ".topper-student", ".exam-calendar",
      ".exam-row", ".info-card", ".manage-card", ".login-card",
      ".ajm-admission-card", ".ajm-admission-success", ".ajm-admission-form-group",
      ".ajm-result-card", ".person-card", ".glance-card", ".academics-story",
      ".academics-governance", ".academics-explore", ".ajm-marksheet-gate",
      ".ajm-print-sheet", ".ajm-admin-welcome", ".ajm-admin-panel",
    ].join(",");
    const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    let io: IntersectionObserver | null = null;
    if (!reduce && "IntersectionObserver" in window) {
      io = new IntersectionObserver((entries) => entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-revealed");
          io?.unobserve(entry.target);
        }
      }), { threshold: 0.08, rootMargin: "0px 0px -28px" });
    }

    const markAndObserve = () => {
      document.querySelectorAll<HTMLElement>(selectors).forEach((item, index) => {
        if (item.dataset.motion) return;
        item.dataset.motion = "reveal";
        item.style.setProperty("--motion-delay", `${Math.min((index % 5) * 55, 220)}ms`);
        if (reduce || !io) item.classList.add("is-revealed");
        else io.observe(item);
      });
    };

    markAndObserve();
    document.documentElement.classList.add("motion-ready");
    const observer = new MutationObserver(markAndObserve);
    observer.observe(document.body, { childList: true, subtree: true });

    const onClick = (event: MouseEvent) => {
      const link = (event.target as Element | null)?.closest<HTMLAnchorElement>("a[href]");
      if (!link || event.button !== 0 || event.defaultPrevented || link.target || link.hasAttribute("download") || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
      const url = new URL(link.href, window.location.href);
      if (
        url.origin === window.location.origin &&
        (url.pathname !== window.location.pathname || url.search !== window.location.search)
      ) {
        setNavigating(true);
        if (navigationTimeout.current !== null) window.clearTimeout(navigationTimeout.current);
        navigationTimeout.current = window.setTimeout(() => setNavigating(false), 2500);
      }
    };
    document.addEventListener("click", onClick, true);
    return () => {
      observer.disconnect();
      io?.disconnect();
      document.removeEventListener("click", onClick, true);
      if (navigationTimeout.current !== null) window.clearTimeout(navigationTimeout.current);
    };
  }, []);

  useEffect(() => {
    setNavigating(false);
    if (navigationTimeout.current !== null) {
      window.clearTimeout(navigationTimeout.current);
      navigationTimeout.current = null;
    }
  }, [pathname]);

  return <div className={navigating ? "app-motion is-navigating" : "app-motion"} aria-busy={navigating}>{children}</div>;
}
