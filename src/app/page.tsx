"use client";

import Image from "next/image";
import Link from "next/link";
import {
  ArrowDown, ArrowRight, ArrowUpRight, BookOpen, CalendarDays,
  ChartNoAxesColumnIncreasing, ChevronLeft, ChevronRight, Clock3,
  GraduationCap, HeartHandshake, Lightbulb, MapPin, Pause, Play,
  ShieldCheck, Sparkles, Star, Users, Wallet, Zap,
} from "lucide-react";
import { useEffect, useRef, useState } from "react";

const slides = [
  { image: "/uploads/AJM English School Entrance.png", label: "THE AJM EXPERIENCE", title: "A place to discover.", detail: "Curiosity starts here." },
  { image: "/uploads/A.J.M. English School Entrance.png", label: "LEARNING TOGETHER", title: "Room to become.", detail: "Every learner matters." },
  { image: "/uploads/AJM English School Entrance Under Blue Skies.png", label: "LIFE AT AJM", title: "Memories in the making.", detail: "Growing, every day." },
];

const shortcuts = [
  { no: "01", title: "Exam calendar", desc: "Important dates, clearly organised.", href: "/exam-dates", action: "Explore dates", icon: CalendarDays, tone: "mint" },
  { no: "02", title: "Student results", desc: "Find results and academic updates.", href: "/results", action: "View results", icon: ChartNoAxesColumnIncreasing, tone: "butter" },
  { no: "03", title: "Fee information", desc: "Fees and the next steps for families.", href: "/fees", action: "Fee details", icon: Wallet, tone: "blush" },
  { no: "04", title: "Life at AJM", desc: "Discover our school community.", href: "/gallery", action: "Explore gallery", icon: Users, tone: "sky" },
];

const principles = [
  { icon: Lightbulb, title: "Stay curious", text: "Ask questions. Explore possibilities. Keep discovering." },
  { icon: HeartHandshake, title: "Grow together", text: "Build friendships, respect and a sense of belonging." },
  { icon: ShieldCheck, title: "Find confidence", text: "Develop the courage to take the next step." },
];

function useReveal() {
  useEffect(() => {
    const nodes = document.querySelectorAll<HTMLElement>("[data-reveal]");
    if (!("IntersectionObserver" in window)) {
      nodes.forEach((node) => node.classList.add("ajm-in"));
      return;
    }
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("ajm-in");
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.08 });
    nodes.forEach((node) => observer.observe(node));
    return () => observer.disconnect();
  }, []);
}

function SchoolClock() {
  const [time, setTime] = useState("");
  useEffect(() => {
    const update = () => setTime(new Intl.DateTimeFormat("en-IN", { hour: "2-digit", minute: "2-digit", hour12: true, timeZone: "Asia/Kolkata" }).format(new Date()));
    update();
    const timer = window.setInterval(update, 30_000);
    return () => window.clearInterval(timer);
  }, []);
  return <span className="ajm-clock"><span className="ajm-live-dot" /><Clock3 size={14} />{time || "IST"}<span className="clock-label">IST</span></span>;
}

function Announcement() {
  const messages = [
    { label: "FROM THE SCHOOL", text: "Every learner has a story. We're here to help them write it.", icon: Sparkles },
    { label: "OUR PHILOSOPHY", text: "Small steps today. Extraordinary possibilities tomorrow.", icon: HeartHandshake },
    { label: "A LOVE FOR LEARNING", text: "Curiosity opens doors that knowledge helps us walk through.", icon: BookOpen },
    { label: "STAY INFORMED", text: "Keep up with school updates, examination dates and important notices.", icon: CalendarDays },
  ];
  return <div className="ajm-announcement" aria-label="School announcements"><div className="ajm-marquee">{[0, 1].map((group) => <div className="ajm-marquee-group" key={group} aria-hidden={group === 1}>{messages.map((message, index) => { const Icon = message.icon; return <span className="ajm-announcement-item" key={`${group}-${index}`}><Icon size={13} /><b>{message.label}</b>{message.text}<i /></span>; })}</div>)}</div></div>;
}

function Hero() {
  const [slide, setSlide] = useState(0);
  const [paused, setPaused] = useState(false);
  const [loaded, setLoaded] = useState(false);
  const touchStart = useRef<number | null>(null);
  useEffect(() => {
    if (paused) return;
    const timer = window.setInterval(() => { setSlide((current) => (current + 1) % slides.length); setLoaded(false); }, 6500);
    return () => window.clearInterval(timer);
  }, [paused]);
  const change = (amount: number) => { setSlide((current) => (current + amount + slides.length) % slides.length); setLoaded(false); };
  const current = slides[slide];
  return (
    <section className="ajm-hero">
      <div className="ajm-hero-glow glow-a" /><div className="ajm-hero-glow glow-b" /><div className="ajm-hero-grain" />
      <div className="ajm-container ajm-hero-grid">
        <div className="ajm-hero-copy">
          <div className="ajm-eyebrow"><span /> A SCHOOL WITH ROOM TO GROW</div>
          <div className="ajm-hero-index">0{slide + 1} <span>/</span> 03</div>
          <h1>Big dreams<br />begin <em>right here.</em></h1>
          <p className="ajm-hero-lede">An education that goes beyond the classroom — building curious minds, kind hearts and the confidence to shape tomorrow.</p>
          <div className="ajm-hero-actions"><Link href="/admissions" className="ajm-button ajm-button-dark">Apply for Admission <ArrowUpRight size={17} /></Link><Link href="/academics" className="ajm-play-link"><span><BookOpen size={15} /></span>Explore our school</Link></div>
          <div className="ajm-trust-row"><div className="ajm-avatar-stack"><span>A</span><span>J</span><span>M</span></div><div className="ajm-trust-copy"><b>A community that cares</b><small>Learning, belonging, becoming.</small></div><span className="ajm-trust-divider" /><div className="ajm-location-mini"><MapPin size={16} /><span>Gossaigaon<br />Assam, India</span></div></div>
          <a className="ajm-scroll-cue" href="#quick-access"><span>SCROLL TO DISCOVER</span><ArrowDown size={14} /></a>
        </div>
        <div className="ajm-hero-visual" onTouchStart={(event) => { touchStart.current = event.touches[0]?.clientX ?? null; }} onTouchEnd={(event) => { if (touchStart.current !== null) { const delta = event.changedTouches[0].clientX - touchStart.current; if (Math.abs(delta) > 45) change(delta < 0 ? 1 : -1); } touchStart.current = null; }}>
          <div className="ajm-photo-halo" /><div className="ajm-photo-frame"><div className={`ajm-photo-stage ${loaded ? "photo-loaded" : ""}`} key={current.image}><Image src={current.image} alt={current.title} fill priority={slide === 0} sizes="(max-width: 760px) 100vw, 52vw" className="ajm-hero-photo" onLoad={() => setLoaded(true)} /></div><div className="ajm-photo-shade" /><div className="ajm-photo-top"><span className="ajm-live-dot" /><span>WELCOME TO AJM</span><Sparkles size={16} /></div><div className="ajm-photo-caption" key={current.title}><small>{current.label}</small><h2>{current.title}</h2><p>{current.detail}</p></div><div className="ajm-photo-controls"><button onClick={() => change(-1)} aria-label="Previous image"><ChevronLeft size={18} /></button><div className="ajm-slide-dots">{slides.map((item, index) => <button key={item.image} aria-label={`Show slide ${index + 1}`} className={index === slide ? "active" : ""} onClick={() => { setSlide(index); setLoaded(false); }} />)}</div><button onClick={() => change(1)} aria-label="Next image"><ChevronRight size={18} /></button><button className="ajm-pause" onClick={() => setPaused((value) => !value)} aria-label={paused ? "Resume slideshow" : "Pause slideshow"}>{paused ? <Play size={14} /> : <Pause size={14} />}</button></div></div>
          <div className="ajm-float-card ajm-float-one"><span className="ajm-float-icon gold"><Star size={18} /></span><span><b>Every child matters.</b><small>A place to find your potential.</small></span></div><div className="ajm-float-card ajm-float-two"><span className="ajm-float-icon green"><Zap size={18} /></span><span><b>Learn. Lead. Belong.</b><small>Your journey starts here.</small></span></div><div className="ajm-vertical-note">GOSSAIGAON · ASSAM · INDIA</div>
        </div>
      </div>
    </section>
  );
}

function QuickAccess() {
  return <section className="ajm-quick-section" id="quick-access"><div className="ajm-container"><div className="ajm-section-heading" data-reveal><div><span className="ajm-kicker">YOUR SCHOOL, ONE CLICK AWAY</span><h2>The essentials, <em>made simple.</em></h2></div><p>Everything important, right where you need it.</p></div><div className="ajm-quick-grid">{shortcuts.map((item, index) => { const Icon = item.icon; return <Link href={item.href} key={item.no} className={`ajm-quick-card tone-${item.tone}`} data-reveal style={{ "--delay": `${index * 70}ms` } as React.CSSProperties}><div className="ajm-quick-top"><span>{item.no} <i>/ 04</i></span><span className="ajm-quick-icon"><Icon size={22} /></span></div><h3>{item.title}</h3><p>{item.desc}</p><div className="ajm-quick-bottom"><span>{item.action}</span><span className="ajm-quick-arrow"><ArrowUpRight size={17} /></span></div><span className="ajm-card-shine" /></Link>; })}</div></div></section>;
}

function Story() {
  return <section className="ajm-story" id="story"><div className="ajm-container ajm-story-grid"><div className="ajm-story-art" data-reveal><div className="ajm-story-image"><Image src="/uploads/20250701_122231.jpg" alt="The AJM English School community" fill sizes="(max-width: 760px) 100vw, 50vw" /></div><div className="ajm-story-frame" /><div className="ajm-story-sticker"><Sparkles size={18} /><b>Made for<br />possibility.</b></div><div className="ajm-story-image-note"><span>01 — OUR BELIEF</span><span>EVERY CHILD CAN FLOURISH</span></div></div><div className="ajm-story-copy" data-reveal><div className="ajm-eyebrow"><span /> THE AJM DIFFERENCE</div><h2>Education should<br />open <em>every door.</em></h2><p>We believe the best learning happens when students feel seen, supported and challenged. Our school community brings together strong foundations, thoughtful guidance and the freedom to ask bigger questions.</p><p>From the first lesson to the next big ambition, we want every learner to leave with knowledge, confidence and a sense of responsibility to the world around them.</p><Link href="/academics" className="ajm-underlined">Discover our approach <ArrowUpRight size={16} /></Link><div className="ajm-principles">{principles.map(({ icon: Icon, title, text }) => <div className="ajm-principle" key={title}><span><Icon size={19} /></span><b>{title}</b><small>{text}</small></div>)}</div></div></div></section>;
}

function ValuesMarquee() {
  const values = ["Curiosity opens doors", "Every learner belongs", "Small steps, big possibilities", "Learn with purpose"];
  return <div className="ajm-values-marquee" aria-label="School values"><div>{[0, 1].map((group) => <div className="ajm-values-group" key={group} aria-hidden={group === 1}>{values.map((value) => <span key={value}><Sparkles size={15} />{value}</span>)}</div>)}</div></div>;
}

function Campus() {
  const cards = [
    { image: "/uploads/20250701_122252.jpg", no: "01", title: "Life at AJM", text: "The moments that make memories." },
    { image: "/teachers/WhatsApp%20Image%202025-07-09%20at%2023.16.02_0391f9d4.jpg", no: "02", title: "Our people", text: "The people who help us grow.", href: "/academics" },
    { image: "/uploads/20250701_122201.jpg", no: "03", title: "Our community", text: "Growing stronger, together." },
  ];
  return <section className="ajm-campus"><div className="ajm-container"><div className="ajm-section-heading" data-reveal><div><span className="ajm-kicker">A LITTLE LOOK AROUND</span><h2>Small moments.<br /><em>Big beginnings.</em></h2></div><Link href="/gallery" className="ajm-underlined">Explore the gallery <ArrowUpRight size={16} /></Link></div><div className="ajm-campus-grid">{cards.map((card, index) => <Link href={card.href ?? "/gallery"} className="ajm-campus-card" key={card.no} data-reveal style={{ "--delay": `${index * 80}ms` } as React.CSSProperties}><div className="ajm-campus-image"><Image src={card.image} alt={card.title} fill sizes="(max-width: 760px) 90vw, 33vw" /><span>{card.no}</span><i><ArrowUpRight size={18} /></i></div><div className="ajm-campus-copy"><div><h3>{card.title}</h3><p>{card.text}</p></div><ArrowRight size={18} /></div></Link>)}</div></div></section>;
}

function Contact() {
  return <section className="ajm-contact" id="contact"><div className="ajm-contact-glow" /><div className="ajm-container ajm-contact-grid"><div data-reveal><span className="ajm-kicker">YOUR NEXT CHAPTER STARTS HERE</span><h2>Come grow<br /><em>with us.</em></h2><p>Have a question about admissions, classes or school life? We&apos;d love to hear from you.</p><div className="ajm-contact-location"><MapPin size={18} /><span>AJM English School<br />Gossaigaon, Assam, India</span></div><Link href="/admissions" className="ajm-button ajm-button-light">Apply for Admission <ArrowUpRight size={17} /></Link></div><div className="ajm-contact-art" data-reveal><div className="ajm-contact-orbit"><span /><span /><GraduationCap size={64} strokeWidth={1} /><small>LEARN · LEAD · BELONG</small></div><div className="ajm-contact-art-foot">EVERY LEARNER HAS A STORY <Sparkles size={16} /></div></div></div></section>;
}

export default function Home() {
  useReveal();
  return <main id="top" className="ajm-premium-home"><Announcement /><Hero /><QuickAccess /><Story /><ValuesMarquee /><section className="ajm-promise"><div className="ajm-promise-orbit" /><div className="ajm-promise-content" data-reveal><span className="ajm-promise-icon"><GraduationCap size={29} /></span><span className="ajm-kicker">A PROMISE THAT GUIDES US</span><h2>A strong foundation for a<br /><em>life of possibility.</em></h2><p>The future is not simply something to prepare for. It is something to help shape.</p><Link href="/academics" className="ajm-underlined">Explore learning at AJM <ArrowUpRight size={16} /></Link></div></section><Campus /><Contact /><div className="ajm-clock-dock"><SchoolClock /></div>
    <style jsx global>{`
      .ajm-premium-home{--navy:#142a40;--ink:#182b3c;--muted:#667582;--gold:#c69a4b;--cream:#fbf8f1;--line:rgba(20,42,64,.12);color:var(--ink);overflow:hidden;background:#fff;font-family:inherit}
      .ajm-premium-home *{box-sizing:border-box}.ajm-container{width:min(1200px,calc(100% - 64px));margin-inline:auto}
      .ajm-announcement{height:35px;overflow:hidden;background:var(--navy);color:#f9f5ec;display:flex;align-items:center;font-size:10px;letter-spacing:.04em}.ajm-marquee{display:flex;width:max-content;animation:ajmTicker 65s linear infinite}.ajm-marquee-group{display:flex;align-items:center;flex-shrink:0}.ajm-announcement-item{display:flex;align-items:center;gap:9px;padding:0 24px;white-space:nowrap}.ajm-announcement-item svg{color:#e2bd79}.ajm-announcement-item b{font-size:9px;letter-spacing:.12em;color:#e2bd79}.ajm-announcement-item i{height:4px;width:4px;border-radius:50%;background:#e2bd79;margin-left:8px}
      .ajm-hero{position:relative;isolation:isolate;background:linear-gradient(115deg,#fcfaf5 0%,#f6f3ec 55%,#f3f0e8 100%);padding:72px 0 86px}.ajm-hero-grid{display:grid;grid-template-columns:.9fr 1.1fr;gap:58px;align-items:center;position:relative;z-index:1}.ajm-hero-copy{position:relative;z-index:2;padding:8px 0}.ajm-eyebrow{display:flex;align-items:center;gap:10px;color:#6d776e;font-size:10px;letter-spacing:.16em;font-weight:700}.ajm-eyebrow>span{width:23px;height:1px;background:var(--gold)}.ajm-hero-index{margin-top:38px;color:#8a8f89;font:12px/1.2 ui-monospace,monospace;letter-spacing:.12em}.ajm-hero-index span{color:#c7a66c;margin:0 7px}.ajm-hero h1,.ajm-story h2,.ajm-section-heading h2,.ajm-contact h2,.ajm-promise h2{font-size:clamp(44px,5.1vw,70px);font-weight:500;line-height:1.04;letter-spacing:-.055em;margin:19px 0 23px;color:var(--navy)}.ajm-premium-home h1 em,.ajm-premium-home h2 em{font-family:Georgia,serif;font-weight:400;color:#b48a45}.ajm-hero-lede{max-width:450px;font-size:15px;line-height:1.85;color:#66727a;margin:0}.ajm-hero-actions{display:flex;align-items:center;gap:22px;flex-wrap:wrap;margin-top:30px}.ajm-button{display:inline-flex;align-items:center;justify-content:center;gap:18px;min-height:52px;padding:0 21px;border-radius:5px;text-decoration:none;font-size:12px;font-weight:650;transition:transform .2s,background .2s}.ajm-button:hover{transform:translateY(-2px)}.ajm-button-dark{background:var(--navy);color:#fff}.ajm-play-link{display:inline-flex;align-items:center;gap:10px;color:var(--navy);font-size:12px;text-decoration:none;font-weight:600}.ajm-play-link>span{width:34px;height:34px;border:1px solid #d5d2c8;border-radius:50%;display:grid;place-items:center}.ajm-trust-row{display:flex;align-items:center;gap:12px;margin-top:40px}.ajm-avatar-stack{display:flex;padding-left:2px}.ajm-avatar-stack span{width:28px;height:28px;margin-left:-3px;display:grid;place-items:center;border:2px solid #f8f5ee;border-radius:50%;background:#dce5de;color:#304b4a;font-size:9px;font-weight:800}.ajm-avatar-stack span:nth-child(2){background:#eadcc6}.ajm-avatar-stack span:nth-child(3){background:#d7e2ec}.ajm-trust-copy{display:grid;gap:4px}.ajm-trust-copy b{font-size:11px;color:#24394a}.ajm-trust-copy small{font-size:10px;color:#7a858b}.ajm-trust-divider{height:30px;width:1px;background:#d8d4ca;margin:0 4px}.ajm-location-mini{display:flex;align-items:center;gap:7px;color:#b28a49}.ajm-location-mini span{font-size:10px;line-height:1.5;color:#68747c}.ajm-scroll-cue{display:flex;align-items:center;gap:10px;margin-top:43px;text-decoration:none;color:#89918f;font-size:9px;letter-spacing:.15em}.ajm-scroll-cue svg{color:#b48a45}.ajm-hero-glow{position:absolute;z-index:-1;border-radius:50%;filter:blur(2px);pointer-events:none}.glow-a{width:320px;height:320px;right:0;top:-140px;background:radial-gradient(circle,rgba(218,196,153,.23),transparent 70%)}.glow-b{width:250px;height:250px;left:-100px;bottom:-100px;background:radial-gradient(circle,rgba(197,216,211,.32),transparent 70%)}.ajm-hero-grain{position:absolute;inset:0;z-index:-1;opacity:.15;pointer-events:none;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 180 180' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.12'/%3E%3C/svg%3E")}
      .ajm-hero-visual{position:relative;min-width:0;padding:0 12px 18px 0}.ajm-photo-halo{position:absolute;inset:7% -2% 0 7%;border:1px solid rgba(186,151,88,.45);border-radius:48% 48% 6px 6px;transform:rotate(3deg)}.ajm-photo-frame{position:relative;height:clamp(390px,44vw,570px);border-radius:48% 48% 7px 7px;overflow:hidden;background:#d7d9d4;box-shadow:0 28px 70px rgba(28,42,49,.16)}.ajm-photo-stage{position:absolute;inset:0;opacity:.88;transition:opacity .5s}.ajm-photo-stage.photo-loaded{opacity:1}.ajm-hero-photo{object-fit:cover;object-position:center 45%;transition:transform 7s ease}.ajm-photo-frame:hover .ajm-hero-photo{transform:scale(1.035)}.ajm-photo-shade{position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,30,40,.04) 35%,rgba(13,30,40,.75) 100%)}.ajm-photo-top{position:absolute;top:23px;left:25px;right:25px;display:flex;align-items:center;gap:9px;color:white;font-size:9px;letter-spacing:.16em}.ajm-photo-top svg{margin-left:auto;color:#f0d5a2}.ajm-live-dot{display:inline-block;width:7px;height:7px;flex:0 0 7px;border-radius:50%;background:#8ebba0;box-shadow:0 0 0 4px rgba(142,187,160,.15)}.ajm-photo-caption{position:absolute;left:30px;right:30px;bottom:72px;color:white;animation:ajmRise .45s ease both}.ajm-photo-caption small{font-size:9px;letter-spacing:.17em;color:#e6c88f}.ajm-photo-caption h2{margin:10px 0 5px;font-size:clamp(25px,3vw,40px);font-weight:500;letter-spacing:-.04em}.ajm-photo-caption p{margin:0;color:rgba(255,255,255,.8);font-size:12px}.ajm-photo-controls{position:absolute;left:25px;right:25px;bottom:22px;display:flex;align-items:center;gap:9px}.ajm-photo-controls button{display:grid;place-items:center;width:32px;height:32px;border:1px solid rgba(255,255,255,.4);background:rgba(10,25,34,.15);color:white;border-radius:50%;cursor:pointer}.ajm-slide-dots{display:flex;align-items:center;gap:5px;margin:0 auto}.ajm-slide-dots button{width:6px;height:6px;padding:0;border:0;background:rgba(255,255,255,.55)}.ajm-slide-dots button.active{width:22px;border-radius:6px;background:#e6c88f}.ajm-photo-controls .ajm-pause{width:28px;height:28px}.ajm-float-card{position:absolute;z-index:2;display:flex;align-items:center;gap:11px;padding:12px 15px;background:rgba(255,255,255,.91);backdrop-filter:blur(14px);border:1px solid rgba(255,255,255,.75);box-shadow:0 12px 35px rgba(24,43,60,.13);border-radius:8px}.ajm-float-one{left:-35px;top:22%}.ajm-float-two{right:-18px;bottom:12%}.ajm-float-icon{display:grid;place-items:center;width:35px;height:35px;border-radius:7px}.ajm-float-icon.gold{background:#f5ead5;color:#a67d38}.ajm-float-icon.green{background:#e3eee5;color:#4b7860}.ajm-float-card span:last-child{display:grid;gap:4px}.ajm-float-card b{font-size:10px;color:#24394a}.ajm-float-card small{font-size:9px;color:#7b8589}.ajm-vertical-note{position:absolute;right:-18px;top:35%;writing-mode:vertical-rl;color:#8c928d;font-size:8px;letter-spacing:.19em}
      .ajm-quick-section{position:relative;z-index:3;padding:73px 0 88px;background:#fff}.ajm-section-heading{display:flex;align-items:flex-end;justify-content:space-between;gap:25px;margin-bottom:30px}.ajm-kicker{display:block;color:#9b7a42;font-size:9px;letter-spacing:.16em;font-weight:750}.ajm-section-heading h2{font-size:clamp(30px,3.5vw,45px);margin:12px 0 0}.ajm-section-heading>p{max-width:255px;margin:0 0 4px;color:#7b858b;font-size:12px;line-height:1.7}.ajm-quick-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:13px}.ajm-quick-card{position:relative;display:flex;flex-direction:column;min-height:222px;padding:21px 19px 17px;overflow:hidden;border:1px solid transparent;border-radius:10px;text-decoration:none;color:var(--ink);transition:transform .25s,box-shadow .25s,border-color .25s;transition-delay:var(--delay,0ms)}.ajm-quick-card:hover{transform:translateY(-5px);box-shadow:0 16px 34px rgba(30,48,58,.09);border-color:rgba(20,42,64,.1)}.tone-mint{background:#edf4ef}.tone-butter{background:#f8f2e4}.tone-blush{background:#f7ece8}.tone-sky{background:#eaf1f6}.ajm-quick-top{display:flex;align-items:center;justify-content:space-between;color:#65746f;font:10px ui-monospace,monospace}.ajm-quick-top i{font-style:normal;opacity:.55}.ajm-quick-icon{width:39px;height:39px;display:grid;place-items:center;border-radius:10px;background:rgba(255,255,255,.62);color:#314b54}.ajm-quick-card h3{margin:19px 0 7px;font-size:17px;font-weight:650;letter-spacing:-.025em}.ajm-quick-card p{margin:0;color:#6d7a7f;font-size:11px;line-height:1.65}.ajm-quick-bottom{display:flex;align-items:center;justify-content:space-between;margin-top:auto;padding-top:19px;font-size:10px;font-weight:700}.ajm-quick-arrow{display:grid;place-items:center;width:29px;height:29px;border:1px solid rgba(20,42,64,.18);border-radius:50%;transition:background .2s,color .2s}.ajm-quick-card:hover .ajm-quick-arrow{background:var(--navy);color:white}.ajm-card-shine{position:absolute;top:-40px;right:-30px;width:110px;height:110px;border-radius:50%;background:rgba(255,255,255,.25);pointer-events:none}
      .ajm-story{padding:85px 0 100px;background:var(--cream)}.ajm-story-grid{display:grid;grid-template-columns:1fr 1fr;gap:clamp(45px,8vw,105px);align-items:center}.ajm-story-art{position:relative;padding:0 24px 25px 0}.ajm-story-image{height:clamp(340px,40vw,490px);position:relative;overflow:hidden;border-radius:5px 100px 5px 5px;background:#e0e0d9}.ajm-story-image img{object-fit:cover;object-position:center}.ajm-story-frame{position:absolute;z-index:0;inset:22px 0 0 23px;border:1px solid #c9ad78;border-radius:5px 100px 5px 5px;pointer-events:none}.ajm-story-sticker{position:absolute;right:-5px;bottom:62px;display:flex;align-items:center;gap:10px;padding:15px 18px;background:#fffdf8;box-shadow:0 10px 25px #24394a18;color:#b18a48;border-radius:6px}.ajm-story-sticker b{font:17px/1.1 Georgia,serif;color:#24394a}.ajm-story-image-note{position:absolute;left:13px;right:40px;bottom:0;display:flex;justify-content:space-between;gap:10px;color:#7d8986;font-size:8px;letter-spacing:.11em}.ajm-story-copy h2{font-size:clamp(36px,4.2vw,55px);margin:17px 0 22px}.ajm-story-copy>p,.ajm-contact-grid>div:first-child>p{color:#69767c;font-size:13px;line-height:1.9}.ajm-story-copy>p+p{margin-top:12px}.ajm-underlined{display:inline-flex;align-items:center;gap:12px;padding:0 0 8px;border-bottom:1px solid #c4a66f;color:var(--navy);font-size:11px;font-weight:700;text-decoration:none;margin-top:13px}.ajm-principles{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:15px;margin-top:35px;padding-top:23px;border-top:1px solid #e5dfd2}.ajm-principle{display:flex;flex-direction:column;align-items:flex-start;gap:8px}.ajm-principle>span{width:35px;height:35px;display:grid;place-items:center;background:#eee7d9;border-radius:8px;color:#9c7b43}.ajm-principle b{font-size:11px}.ajm-principle small{font-size:10px;line-height:1.6;color:#78827f}
      .ajm-values-marquee{overflow:hidden;background:#f1e8d7;padding:18px 0;color:#7b633e}.ajm-values-marquee>div{display:flex;width:max-content;animation:ajmTicker 35s linear infinite}.ajm-values-group{display:flex;align-items:center;gap:42px;padding-right:42px}.ajm-values-group span{display:flex;align-items:center;gap:10px;white-space:nowrap;font:italic 17px Georgia,serif}.ajm-values-group svg{color:#b18a48}.ajm-promise{position:relative;overflow:hidden;padding:100px 24px;background:#142a40;color:#fff;text-align:center}.ajm-promise-content{position:relative;z-index:1;max-width:690px;margin:auto}.ajm-promise-icon{display:grid;place-items:center;width:54px;height:54px;margin:0 auto 23px;border:1px solid #c8a566;border-radius:50%;color:#e0c18a}.ajm-promise .ajm-kicker{color:#e0c18a}.ajm-promise h2{font-size:clamp(34px,4.2vw,53px);color:#fff;margin:18px 0}.ajm-promise h2 em{color:#e0c18a}.ajm-promise p{max-width:440px;margin:0 auto;color:#c2ccd1;font-size:13px;line-height:1.8}.ajm-promise .ajm-underlined{margin-top:24px;color:white;border-color:#c8a566}.ajm-promise-orbit{position:absolute;width:520px;height:520px;left:50%;top:50%;transform:translate(-50%,-50%);border:1px solid rgba(226,193,138,.15);border-radius:50%;box-shadow:0 0 0 55px rgba(226,193,138,.025),0 0 0 110px rgba(226,193,138,.02)}
      .ajm-campus{padding:82px 0 95px;background:#fff}.ajm-campus-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px}.ajm-campus-card{display:block;min-width:0;color:var(--ink);text-decoration:none}.ajm-campus-image{position:relative;height:clamp(220px,26vw,330px);overflow:hidden;border-radius:7px;background:#e3e6e1}.ajm-campus-image img{object-fit:cover;transition:transform .5s}.ajm-campus-card:hover .ajm-campus-image img{transform:scale(1.04)}.ajm-campus-image>span{position:absolute;top:13px;left:13px;color:#fff;font:10px ui-monospace,monospace;text-shadow:0 1px 8px #0008}.ajm-campus-image>i{position:absolute;right:13px;bottom:13px;width:35px;height:35px;display:grid;place-items:center;border-radius:50%;background:#fff;color:var(--navy);font-style:normal}.ajm-campus-copy{display:flex;align-items:center;justify-content:space-between;padding:16px 1px}.ajm-campus-copy h3{margin:0 0 5px;font-size:16px;font-weight:650}.ajm-campus-copy p{margin:0;color:#7b858b;font-size:11px}.ajm-campus-copy>svg{color:#b18a48}
      .ajm-contact{position:relative;overflow:hidden;padding:80px 0;background:#f5f0e6}.ajm-contact-grid{position:relative;display:grid;grid-template-columns:1fr .8fr;gap:50px;align-items:center}.ajm-contact h2{font-size:clamp(45px,5.2vw,68px);margin:17px 0}.ajm-contact-grid>div:first-child>p{max-width:400px}.ajm-contact-location{display:flex;align-items:center;gap:10px;margin:23px 0;color:#a27d41}.ajm-contact-location span{font-size:11px;line-height:1.7;color:#586972}.ajm-button-light{background:#fff;color:var(--navy);border:1px solid #e5dccb}.ajm-contact-art{display:flex;flex-direction:column;align-items:center}.ajm-contact-orbit{width:min(320px,100%);aspect-ratio:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;position:relative;border:1px solid #d9c8a6;border-radius:50%;color:#b18a48}.ajm-contact-orbit:before,.ajm-contact-orbit:after{content:"";position:absolute;inset:18px;border:1px solid #e4d8c1;border-radius:50%}.ajm-contact-orbit:after{inset:40px;border-style:dashed;opacity:.7}.ajm-contact-orbit>span{position:absolute;width:8px;height:8px;background:#c39b58;border-radius:50%;top:16%;right:25%}.ajm-contact-orbit>span:nth-child(2){top:auto;right:auto;bottom:20%;left:17%;background:#9db6a4}.ajm-contact-orbit svg,.ajm-contact-orbit small{position:relative;z-index:1}.ajm-contact-orbit small{font-size:9px;letter-spacing:.16em;color:#66747b}.ajm-contact-art-foot{display:flex;align-items:center;gap:9px;margin-top:18px;color:#8c7a5b;font-size:8px;letter-spacing:.13em}.ajm-clock-dock{position:fixed;z-index:30;right:16px;bottom:15px}.ajm-clock{display:flex;align-items:center;gap:7px;padding:9px 12px;border:1px solid #ffffff80;border-radius:30px;background:#fffdf0e8;backdrop-filter:blur(14px);box-shadow:0 4px 18px #172b3c12;color:#344a56;font-size:10px}.ajm-clock .clock-label{color:#8d9695;font-size:8px;letter-spacing:.1em}.ajm-in{animation:ajmReveal .65s cubic-bezier(.2,.7,.2,1) both}.ajm-premium-home [data-reveal]{opacity:0;transform:translateY(18px)}.ajm-premium-home [data-reveal].ajm-in{opacity:1;transform:translateY(0)}
      @keyframes ajmTicker{to{transform:translateX(-50%)}}@keyframes ajmReveal{to{opacity:1;transform:translateY(0)}}@keyframes ajmRise{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}
      @media(max-width:1000px){.ajm-container{width:min(100% - 44px,800px)}.ajm-hero{padding:55px 0 65px}.ajm-hero-grid{gap:30px;grid-template-columns:.9fr 1.1fr}.ajm-float-one{left:-15px}.ajm-float-two{right:-8px}.ajm-quick-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.ajm-quick-card{min-height:200px}.ajm-story-grid{gap:45px}.ajm-principles{gap:10px}}
      @media(max-width:760px){.ajm-container{width:calc(100% - 36px)}.ajm-announcement{height:31px}.ajm-announcement-item{gap:7px;padding:0 15px;font-size:9px}.ajm-announcement-item b{font-size:8px}.ajm-hero{padding:27px 0 28px}.ajm-hero-grid{display:flex;flex-direction:column;gap:0;align-items:stretch}.ajm-hero-visual{order:0;padding:0 0 8px;margin:0 1px 23px}.ajm-photo-halo{inset:5% -2% 0 5%;border-radius:43% 43% 5px 5px}.ajm-photo-frame{height:clamp(270px,76vw,410px);border-radius:43% 43% 6px 6px;box-shadow:0 16px 40px #1c2a311c}.ajm-photo-top{top:17px;left:18px;right:18px;font-size:8px}.ajm-photo-caption{left:19px;right:19px;bottom:61px}.ajm-photo-caption h2{font-size:clamp(24px,7vw,32px)}.ajm-photo-caption p{font-size:11px}.ajm-photo-controls{left:17px;right:17px;bottom:15px}.ajm-photo-controls button{width:29px;height:29px}.ajm-float-card{padding:9px 10px;gap:8px;border-radius:7px;box-shadow:0 7px 20px #182b3c1b}.ajm-float-one{left:-5px;top:auto;bottom:24px}.ajm-float-two{right:-4px;bottom:17px}.ajm-float-icon{width:28px;height:28px}.ajm-float-icon svg{width:15px;height:15px}.ajm-float-card b{font-size:9px}.ajm-float-card small{font-size:8px}.ajm-vertical-note{display:none}.ajm-hero-copy{padding:0 1px}.ajm-eyebrow{font-size:8px;letter-spacing:.13em}.ajm-hero-index{margin-top:17px;font-size:10px}.ajm-hero h1{font-size:clamp(43px,12vw,59px);line-height:.99;margin:12px 0 15px;letter-spacing:-.06em}.ajm-hero-lede{font-size:13px;line-height:1.7;max-width:520px}.ajm-hero-actions{display:grid;grid-template-columns:1fr auto;gap:12px;margin-top:20px}.ajm-button{min-height:48px;padding:0 14px;gap:9px;font-size:11px}.ajm-play-link{gap:7px;font-size:10px;white-space:nowrap}.ajm-play-link>span{width:31px;height:31px}.ajm-trust-row{margin-top:21px;gap:9px}.ajm-avatar-stack span{width:25px;height:25px;font-size:8px}.ajm-trust-copy b{font-size:10px}.ajm-trust-copy small{font-size:9px}.ajm-trust-divider{height:26px;margin:0 1px}.ajm-location-mini{gap:5px}.ajm-location-mini svg{width:13px}.ajm-location-mini span{font-size:9px}.ajm-scroll-cue{display:none}.ajm-quick-section{padding:36px 0 49px;background:#fff}.ajm-section-heading{align-items:flex-start;flex-direction:column;gap:8px;margin-bottom:18px}.ajm-section-heading h2{font-size:clamp(29px,8vw,38px);line-height:1.08;margin-top:8px}.ajm-section-heading>p{font-size:11px;max-width:none}.ajm-quick-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.ajm-quick-card{min-height:174px;padding:14px 13px 12px;border-radius:9px}.ajm-quick-top{font-size:9px}.ajm-quick-icon{width:33px;height:33px;border-radius:8px}.ajm-quick-icon svg{width:18px;height:18px}.ajm-quick-card h3{font-size:14px;line-height:1.2;margin:13px 0 6px}.ajm-quick-card p{font-size:10px;line-height:1.5}.ajm-quick-bottom{padding-top:13px;font-size:9px}.ajm-quick-arrow{width:25px;height:25px}.ajm-quick-arrow svg{width:15px}.ajm-story{padding:52px 0 57px}.ajm-story-grid{grid-template-columns:1fr;gap:34px}.ajm-story-art{padding:0 15px 21px 0}.ajm-story-image{height:clamp(270px,75vw,390px);border-top-right-radius:76px}.ajm-story-frame{inset:15px 0 0 15px;border-top-right-radius:76px}.ajm-story-sticker{right:-3px;bottom:48px;padding:11px 13px}.ajm-story-sticker svg{width:15px}.ajm-story-sticker b{font-size:15px}.ajm-story-image-note{left:2px;right:23px;font-size:7px}.ajm-story-copy h2{font-size:clamp(37px,10vw,49px);margin:13px 0 17px}.ajm-story-copy>p{font-size:12px;line-height:1.8}.ajm-principles{margin-top:24px;padding-top:18px;gap:9px}.ajm-principle{gap:7px}.ajm-principle>span{width:31px;height:31px}.ajm-principle>span svg{width:16px}.ajm-principle b{font-size:10px}.ajm-principle small{font-size:9px;line-height:1.5}.ajm-values-marquee{padding:14px 0}.ajm-values-group{gap:25px;padding-right:25px}.ajm-values-group span{font-size:15px}.ajm-promise{padding:66px 20px}.ajm-promise-icon{width:46px;height:46px;margin-bottom:19px}.ajm-promise h2{font-size:clamp(31px,8.5vw,42px);line-height:1.08;margin:15px 0}.ajm-promise p{font-size:12px}.ajm-promise-orbit{width:340px;height:340px}.ajm-campus{padding:53px 0 60px}.ajm-campus .ajm-section-heading{flex-direction:row;align-items:flex-end;gap:12px}.ajm-campus .ajm-section-heading h2{font-size:clamp(29px,8vw,37px)}.ajm-campus .ajm-section-heading>.ajm-underlined{font-size:9px;white-space:nowrap;gap:5px;margin-bottom:3px}.ajm-campus-grid{grid-template-columns:1fr;gap:16px}.ajm-campus-card{display:grid;grid-template-columns:43% 1fr;gap:13px;align-items:center}.ajm-campus-image{height:130px;border-radius:6px}.ajm-campus-image>span{top:8px;left:9px;font-size:8px}.ajm-campus-image>i{width:27px;height:27px;right:8px;bottom:8px}.ajm-campus-image>i svg{width:15px}.ajm-campus-copy{padding:5px 0}.ajm-campus-copy h3{font-size:14px;line-height:1.3}.ajm-campus-copy p{font-size:10px;line-height:1.5}.ajm-campus-copy>svg{width:15px;flex-shrink:0}.ajm-contact{padding:55px 0 62px}.ajm-contact-grid{grid-template-columns:1fr;gap:34px}.ajm-contact h2{font-size:clamp(46px,12vw,60px);margin:13px 0}.ajm-contact-grid>div:first-child>p{font-size:12px;line-height:1.8}.ajm-contact-location{margin:18px 0}.ajm-contact-orbit{width:min(250px,80vw)}.ajm-contact-art-foot{font-size:7px}.ajm-clock-dock{right:9px;bottom:9px}.ajm-clock{padding:7px 9px;font-size:9px;gap:5px}.ajm-clock svg{width:12px;height:12px}}
      @media(max-width:380px){.ajm-container{width:calc(100% - 28px)}.ajm-hero-actions{grid-template-columns:1fr}.ajm-play-link{justify-self:start}.ajm-trust-row{gap:7px}.ajm-trust-copy small{font-size:8px}.ajm-location-mini span{font-size:8px}.ajm-quick-card{padding:12px 10px;min-height:170px}.ajm-quick-card h3{font-size:13px}.ajm-campus-card{grid-template-columns:40% 1fr}.ajm-campus-image{height:112px}.ajm-campus .ajm-section-heading>.ajm-underlined{font-size:8px}}

      /* Mobile refinement: compact, editorial layout with the essentials above the fold. */
      @media(max-width:760px){
        .ajm-announcement{height:29px;display:flex;align-items:center;overflow:hidden}
        .ajm-marquee{width:100%;overflow:hidden}
        .ajm-marquee-group{width:100%;justify-content:center;animation:none!important;transform:none!important}
        .ajm-marquee-group:nth-child(2){display:none}
        .ajm-announcement-item{display:none}
        .ajm-announcement-item:first-child{display:flex;min-width:0;max-width:100%;gap:7px;padding:0 12px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-size:8px}
        .ajm-announcement-item:first-child b{flex-shrink:0;font-size:7px;letter-spacing:.08em}
        .ajm-announcement-item:first-child i{display:none}
        .ajm-hero{padding:20px 0 28px}
        .ajm-hero-grid{gap:0}
        .ajm-hero-copy{padding:0}
        .ajm-eyebrow{font-size:8px;letter-spacing:.14em}
        .ajm-hero-index{margin-top:12px;font-size:9px}
        .ajm-hero h1{font-size:clamp(39px,10.8vw,48px);line-height:.98;letter-spacing:-.055em;margin:10px 0 12px;max-width:350px}
        .ajm-hero-lede{font-size:12px;line-height:1.55;max-width:440px;margin:0}
        .ajm-hero-actions{display:flex;align-items:center;flex-wrap:wrap;gap:10px;margin-top:16px}
        .ajm-button{min-height:44px;padding:0 14px;font-size:10px}
        .ajm-play-link{font-size:10px;gap:7px}
        .ajm-play-link>span{width:29px;height:29px}
        .ajm-trust-row{margin-top:15px;gap:8px;flex-wrap:wrap}
        .ajm-avatar-stack span{width:22px;height:22px}
        .ajm-trust-copy b{font-size:9px}
        .ajm-trust-copy small{font-size:8px}
        .ajm-trust-divider{height:23px}
        .ajm-location-mini span{font-size:8px}
        .ajm-hero-visual{order:1;margin:18px 0 0;padding:0}
        .ajm-photo-halo{display:none}
        .ajm-photo-frame{height:clamp(155px,46vw,205px);border-radius:18px;box-shadow:0 12px 28px #1c2a3118}
        .ajm-photo-stage,.ajm-photo-frame img{border-radius:18px}
        .ajm-hero-photo{object-position:center 48%}
        .ajm-photo-shade{background:linear-gradient(180deg,#10222a12 0%,#10222a08 38%,#07131bcf 100%)}
        .ajm-photo-top{top:12px;left:13px;right:13px;font-size:7px}
        .ajm-photo-top svg{width:13px}
        .ajm-photo-caption{left:14px;right:14px;bottom:43px}
        .ajm-photo-caption small{font-size:7px;letter-spacing:.12em}
        .ajm-photo-caption h2{font-size:clamp(19px,5.7vw,25px);line-height:1.05;margin:4px 0}
        .ajm-photo-caption p{font-size:9px;margin:0}
        .ajm-photo-controls{left:12px;right:12px;bottom:9px;gap:7px}
        .ajm-photo-controls button{width:25px;height:25px}
        .ajm-photo-controls svg{width:14px}
        .ajm-slide-dots{gap:5px}
        .ajm-slide-dots button{width:5px;height:5px}
        .ajm-float-card,.ajm-vertical-note{display:none!important}
        .ajm-quick-section{padding:29px 0 40px;background:#fff}
        .ajm-section-heading{margin-bottom:15px;gap:5px}
        .ajm-section-heading .ajm-kicker{font-size:7px;letter-spacing:.14em}
        .ajm-section-heading h2{font-size:clamp(27px,7.3vw,33px);line-height:1.05;margin:6px 0 0}
        .ajm-section-heading>p{font-size:10px;line-height:1.5;margin:0}
        .ajm-quick-grid{gap:9px}
        .ajm-quick-card{min-height:146px;padding:12px 11px 10px;border-radius:10px}
        .ajm-quick-top{font-size:8px}
        .ajm-quick-icon{width:29px;height:29px}
        .ajm-quick-icon svg{width:16px;height:16px}
        .ajm-quick-card h3{font-size:13px;margin:10px 0 5px}
        .ajm-quick-card p{font-size:9px;line-height:1.4}
        .ajm-quick-bottom{padding-top:9px;font-size:8px}
        .ajm-quick-arrow{width:22px;height:22px}
        .ajm-clock-dock{right:10px;bottom:10px}
        .ajm-clock{padding:6px 8px;font-size:8px}
      }
      @media(max-width:380px){
        .ajm-hero h1{font-size:39px}
        .ajm-hero-actions{gap:8px}
        .ajm-button{padding:0 11px;font-size:9px}
        .ajm-trust-row{gap:6px}
        .ajm-trust-divider{display:none}
        .ajm-location-mini{margin-left:auto}
        .ajm-photo-frame{height:158px}
        .ajm-quick-card{min-height:143px;padding:10px}
      }
      @media(prefers-reduced-motion:reduce){.ajm-premium-home *, .ajm-premium-home *:before,.ajm-premium-home *:after{animation-duration:.01ms!important;animation-iteration-count:1!important;scroll-behavior:auto!important;transition-duration:.01ms!important}.ajm-marquee,.ajm-values-marquee>div{animation:none}.ajm-premium-home [data-reveal]{opacity:1;transform:none}}
    `}</style>
  </main>;
}
