"use client";

import Image from "next/image";
import Link from "next/link";
import {
  ArrowDown,
  ArrowRight,
  ArrowUpRight,
  BookOpen,
  CalendarDays,
  ChartNoAxesColumnIncreasing,
  ChevronLeft,
  ChevronRight,
  Clock3,
  GraduationCap,
  HeartHandshake,
  Lightbulb,
  MapPin,
  Menu,
  Pause,
  Play,
  ShieldCheck,
  Sparkles,
  Star,
  Users,
  Wallet,
  X,
  Zap,
} from "lucide-react";
import { useEffect, useRef, useState } from "react";

const slides = [
  {
    image: "/uploads/20250701_122201.jpg",
    label: "THE AJM EXPERIENCE",
    title: "A place to discover.",
    detail: "Curiosity starts here.",
  },
  {
    image: "/uploads/20250701_122231.jpg",
    label: "LEARNING TOGETHER",
    title: "Room to become.",
    detail: "Every learner matters.",
  },
  {
    image: "/uploads/20250701_122252.jpg",
    label: "LIFE AT AJM",
    title: "Memories in the making.",
    detail: "Growing, every day.",
  },
];

const shortcuts = [
  {
    no: "01",
    title: "Exam calendar",
    desc: "Know what's coming. Plan with confidence.",
    href: "/exam-dates",
    action: "Explore dates",
    icon: CalendarDays,
    tone: "mint",
  },
  {
    no: "02",
    title: "Student results",
    desc: "Find academic updates and result information.",
    href: "/results",
    action: "View results",
    icon: ChartNoAxesColumnIncreasing,
    tone: "butter",
  },
  {
    no: "03",
    title: "Fee information",
    desc: "Understand fees and your next steps.",
    href: "/fees",
    action: "Fee details",
    icon: Wallet,
    tone: "blush",
  },
  {
    no: "04",
    title: "Life at AJM",
    desc: "Discover the people and moments that make us.",
    href: "/gallery",
    action: "Explore gallery",
    icon: Users,
    tone: "sky",
  },
];

const principles = [
  {
    icon: Lightbulb,
    title: "Stay curious",
    text: "Ask questions. Explore possibilities. Keep discovering.",
  },
  {
    icon: HeartHandshake,
    title: "Grow together",
    text: "Build friendships, respect and a sense of belonging.",
  },
  {
    icon: ShieldCheck,
    title: "Find confidence",
    text: "Develop the courage to take the next step.",
  },
];

function useReveal() {
  useEffect(() => {
    const nodes = document.querySelectorAll<HTMLElement>("[data-reveal]");

    if (!("IntersectionObserver" in window)) {
      nodes.forEach((node) => node.classList.add("ajm-in"));
      return;
    }

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("ajm-in");
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12 }
    );

    nodes.forEach((node) => observer.observe(node));

    return () => observer.disconnect();
  }, []);
}

function SchoolClock() {
  const [time, setTime] = useState("");

  useEffect(() => {
    const update = () => {
      setTime(
        new Intl.DateTimeFormat("en-IN", {
          hour: "2-digit",
          minute: "2-digit",
          hour12: true,
          timeZone: "Asia/Kolkata",
        }).format(new Date())
      );
    };

    update();
    const timer = window.setInterval(update, 30_000);

    return () => window.clearInterval(timer);
  }, []);

  return (
    <span className="ajm-clock">
      <span className="ajm-live-dot" />
      <Clock3 size={14} />
      {time || "IST"}
      <span className="clock-label">IST</span>
    </span>
  );
}

function Announcement() {
  const messages = [
    { label: "FROM THE SCHOOL", text: "Every learner has a story. We're here to help them write it.", icon: Sparkles },
    { label: "OUR PHILOSOPHY", text: "Small steps today. Extraordinary possibilities tomorrow.", icon: HeartHandshake },
    { label: "A LOVE FOR LEARNING", text: "Curiosity opens doors that knowledge helps us walk through.", icon: BookOpen },
    { label: "CELEBRATING PROGRESS", text: "Every effort counts. Every improvement matters.", icon: Star },
    { label: "STAY INFORMED", text: "Keep up with school updates, examination dates and important notices.", icon: CalendarDays },
    { label: "OUR COMMUNITY", text: "A stronger school begins with a community that cares.", icon: Users },
    { label: "GROW WITH CONFIDENCE", text: "Learn with courage. Ask questions. Discover your potential.", icon: Sparkles },
    { label: "BEYOND THE CLASSROOM", text: "Education is about learning to ask better questions.", icon: Lightbulb },
    { label: "A NOTE TO PARENTS", text: "Thank you for being part of every child's journey.", icon: HeartHandshake },
    { label: "THE AJM SPIRIT", text: "Learn. Lead. Belong. Together, we make every day count.", icon: GraduationCap },
  ];

  return (
    <div className="ajm-announcement" aria-label="School announcements">
      <div className="ajm-marquee">
        {Array.from({ length: 2 }, (_, groupIndex) => (
          <div className="ajm-marquee-group" key={groupIndex} aria-hidden={groupIndex === 1}>
            {messages.map((message, index) => {
              const Icon = message.icon;
              return (
                <span key={`${groupIndex}-${index}`} className="ajm-announcement-item">
                  <Icon size={13} />
                  <b>{message.label}</b>
                  {message.text}
                  <i />
                </span>
              );
            })}
          </div>
        ))}
      </div>
    </div>
  );
}


function Hero() {
  const [slide, setSlide] = useState(0);
  const [paused, setPaused] = useState(false);
  const [loaded, setLoaded] = useState(false);
  const touchStart = useRef<number | null>(null);

  useEffect(() => {
    if (paused) return;

    const timer = window.setInterval(() => {
      setSlide((current) => (current + 1) % slides.length);
      setLoaded(false);
    }, 6500);

    return () => window.clearInterval(timer);
  }, [paused]);

  const change = (amount: number) => {
    setSlide((current) => (current + amount + slides.length) % slides.length);
    setLoaded(false);
  };

  const current = slides[slide];

  return (
    <section className="ajm-hero">
      <div className="ajm-hero-glow glow-a" />
      <div className="ajm-hero-glow glow-b" />
      <div className="ajm-hero-grain" />

      <div className="ajm-container ajm-hero-grid">
        <div className="ajm-hero-copy">
          <div className="ajm-eyebrow">
            <span /> A SCHOOL WITH ROOM TO GROW
          </div>

          <div className="ajm-hero-index">
            0{slide + 1} <span>/</span> 03
          </div>

          <h1>
            Big dreams
            <br />
            begin <em>right here.</em>
          </h1>

          <p className="ajm-hero-lede">
            An education that goes beyond the classroom — building curious
            minds, kind hearts and the confidence to shape tomorrow.
          </p>

          <div className="ajm-hero-actions">
            <Link
              href="/admissions"
              className="ajm-button ajm-button-dark"
            >
              Apply for Admission <ArrowUpRight size={17} />
            </Link>

            <Link href="/academics" className="ajm-play-link">
              <span>
                <BookOpen size={15} />
              </span>
              Explore our school
            </Link>
          </div>

          <div className="ajm-trust-row">
            <div className="ajm-avatar-stack">
              <span>A</span>
              <span>J</span>
              <span>M</span>
            </div>

            <div className="ajm-trust-copy">
              <b>A community that cares</b>
              <small>Learning, belonging, becoming.</small>
            </div>

            <span className="ajm-trust-divider" />

            <div className="ajm-location-mini">
              <MapPin size={16} />
              <span>
                Gossaigaon
                <br />
                Assam, India
              </span>
            </div>
          </div>

          <a className="ajm-scroll-cue" href="#quick-access">
            <span>SCROLL TO DISCOVER</span>
            <ArrowDown size={14} />
          </a>
        </div>

        <div
          className="ajm-hero-visual"
          onTouchStart={(event) => {
            touchStart.current = event.touches[0]?.clientX ?? null;
          }}
          onTouchEnd={(event) => {
            if (touchStart.current !== null) {
              const delta =
                event.changedTouches[0].clientX - touchStart.current;

              if (Math.abs(delta) > 45) {
                change(delta < 0 ? 1 : -1);
              }
            }

            touchStart.current = null;
          }}
        >
          <div className="ajm-photo-halo" />

          <div className="ajm-photo-frame">
            <div
              className={`ajm-photo-stage ${loaded ? "photo-loaded" : ""}`}
              key={current.image}
            >
              <Image
                src={current.image}
                alt={current.title}
                fill
                priority
                sizes="(max-width: 800px) 100vw, 52vw"
                className="ajm-hero-photo"
                onLoad={() => setLoaded(true)}
              />
            </div>

            <div className="ajm-photo-shade" />

            <div className="ajm-photo-top">
              <span className="ajm-live-dot" />
              <span>WELCOME TO AJM</span>
              <Sparkles size={16} />
            </div>

            <div className="ajm-photo-caption" key={current.title}>
              <small>{current.label}</small>
              <h2>{current.title}</h2>
              <p>{current.detail}</p>
            </div>

            <div className="ajm-photo-controls">
              <button onClick={() => change(-1)} aria-label="Previous image">
                <ChevronLeft size={18} />
              </button>

              <div className="ajm-slide-dots">
                {slides.map((item, index) => (
                  <button
                    key={item.image}
                    aria-label={`Show slide ${index + 1}`}
                    className={index === slide ? "active" : ""}
                    onClick={() => {
                      setSlide(index);
                      setLoaded(false);
                    }}
                  />
                ))}
              </div>

              <button onClick={() => change(1)} aria-label="Next image">
                <ChevronRight size={18} />
              </button>

              <button
                className="ajm-pause"
                onClick={() => setPaused((value) => !value)}
                aria-label={paused ? "Resume slideshow" : "Pause slideshow"}
              >
                {paused ? <Play size={14} /> : <Pause size={14} />}
              </button>
            </div>
          </div>

          <div className="ajm-float-card ajm-float-one">
            <span className="ajm-float-icon gold">
              <Star size={18} />
            </span>
            <span>
              <b>Every child matters.</b>
              <small>A place to find your potential.</small>
            </span>
          </div>

          <div className="ajm-float-card ajm-float-two">
            <span className="ajm-float-icon green">
              <Zap size={18} />
            </span>
            <span>
              <b>Learn. Lead. Belong.</b>
              <small>Your journey starts here.</small>
            </span>
          </div>

          <div className="ajm-vertical-note">
            GOSSAIGAON · ASSAM · INDIA
          </div>
        </div>
      </div>
    </section>
  );
}

function QuickAccess() {
  return (
    <section className="ajm-quick-section" id="quick-access">
      <div className="ajm-container">
        <div className="ajm-section-heading" data-reveal>
          <div>
            <span className="ajm-kicker">YOUR SCHOOL, ONE CLICK AWAY</span>
            <h2>
              The essentials, <em>made simple.</em>
            </h2>
          </div>
          <p>Everything important, right where you need it.</p>
        </div>

        <div className="ajm-quick-grid">
          {shortcuts.map((item, index) => {
            const Icon = item.icon;

            return (
              <Link
                href={item.href}
                key={item.no}
                className={`ajm-quick-card tone-${item.tone}`}
                data-reveal
                style={{ "--delay": `${index * 90}ms` } as React.CSSProperties}
              >
                <div className="ajm-quick-top">
                  <span>
                    {item.no} <i>/ 04</i>
                  </span>
                  <span className="ajm-quick-icon">
                    <Icon size={22} />
                  </span>
                </div>

                <h3>{item.title}</h3>
                <p>{item.desc}</p>

                <div className="ajm-quick-bottom">
                  <span>{item.action}</span>
                  <span className="ajm-quick-arrow">
                    <ArrowUpRight size={17} />
                  </span>
                </div>

                <span className="ajm-card-shine" />
              </Link>
            );
          })}
        </div>
      </div>
    </section>
  );
}

function Story() {
  return (
    <section className="ajm-story" id="story">
      <div className="ajm-container ajm-story-grid">
        <div className="ajm-story-art" data-reveal>
          <div className="ajm-story-image">
            <Image
              src="/uploads/20250701_122231.jpg"
              alt="The AJM English School community"
              fill
              sizes="(max-width: 800px) 100vw, 50vw"
            />
          </div>
          <div className="ajm-story-frame" />
          <div className="ajm-story-sticker">
            <Sparkles size={18} />
            <b>
              Made for
              <br />
              possibility.
            </b>
          </div>
          <div className="ajm-story-image-note">
            <span>01 — OUR BELIEF</span>
            <span>EVERY CHILD CAN FLOURISH</span>
          </div>
        </div>

        <div className="ajm-story-copy" data-reveal>
          <div className="ajm-eyebrow">
            <span /> THE AJM DIFFERENCE
          </div>

          <h2>
            Education should
            <br />
            open <em>every door.</em>
          </h2>

          <p>
            We believe the best learning happens when students feel seen,
            supported and challenged. Our school community brings together
            strong foundations, thoughtful guidance and the freedom to ask
            bigger questions.
          </p>

          <p>
            From the first lesson to the next big ambition, we want every
            learner to leave with knowledge, confidence and a sense of
            responsibility to the world around them.
          </p>

          <Link href="/academics" className="ajm-underlined">
            Discover our approach <ArrowUpRight size={16} />
          </Link>

          <div className="ajm-principles">
            {principles.map(({ icon: Icon, title, text }) => (
              <div className="ajm-principle" key={title}>
                <span>
                  <Icon size={19} />
                </span>
                <b>{title}</b>
                <small>{text}</small>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}

function ValuesMarquee() {
  const values = [
    "Curiosity opens doors",
    "Every learner belongs",
    "Small steps, big possibilities",
    "Learn with purpose",
  ];

  return (
    <div className="ajm-values-marquee" aria-label="School values">
      <div>
        {[0, 1].map((group) => (
          <div
            className="ajm-values-group"
            key={group}
            aria-hidden={group === 1}
          >
            {values.map((value) => (
              <span key={value}>
                <Sparkles size={15} />
                {value}
              </span>
            ))}
          </div>
        ))}
      </div>
    </div>
  );
}

function Campus() {
  const cards = [
    {
      image: "/uploads/20250701_122252.jpg",
      no: "01",
      title: "Life at AJM",
      text: "The moments that make memories.",
    },
    {
      image: "/teachers/WhatsApp%20Image%202025-07-09%20at%2023.16.02_0391f9d4.jpg",
      no: "02",
      title: "Our people",
      text: "The people who help us grow.",
    },
    {
      image: "/uploads/20250701_122201.jpg",
      no: "03",
      title: "Our community",
      text: "Growing stronger, together.",
    },
  ];

  return (
    <section className="ajm-campus">
      <div className="ajm-container">
        <div className="ajm-section-heading" data-reveal>
          <div>
            <span className="ajm-kicker">A LITTLE LOOK AROUND</span>
            <h2>
              Small moments.
              <br />
              <em>Big beginnings.</em>
            </h2>
          </div>
          <Link href="/gallery" className="ajm-underlined">
            Explore the gallery <ArrowUpRight size={16} />
          </Link>
        </div>

        <div className="ajm-campus-grid">
          {cards.map((card, index) => (
            <Link
              href="/gallery"
              className="ajm-campus-card"
              key={card.no}
              data-reveal
              style={{ "--delay": `${index * 100}ms` } as React.CSSProperties}
            >
              <div className="ajm-campus-image">
                <Image
                  src={card.image}
                  alt={card.title}
                  fill
                  sizes="(max-width: 700px) 100vw, 33vw"
                />
                <span>{card.no}</span>
                <i>
                  <ArrowUpRight size={18} />
                </i>
              </div>
              <div className="ajm-campus-copy">
                <div>
                  <h3>{card.title}</h3>
                  <p>{card.text}</p>
                </div>
                <ArrowRight size={18} />
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
}

function Contact() {
  return (
    <section className="ajm-contact" id="contact">
      <div className="ajm-contact-glow" />
      <div className="ajm-container ajm-contact-grid">
        <div data-reveal>
          <span className="ajm-kicker">YOUR NEXT CHAPTER STARTS HERE</span>
          <h2>
            Come grow
            <br />
            <em>with us.</em>
          </h2>
          <p>
            Have a question about admissions, classes or school life? We&apos;d
            love to hear from you.
          </p>

          <div className="ajm-contact-location">
            <MapPin size={18} />
            <span>
              AJM English School
              <br />
              Gossaigaon, Assam, India
            </span>
          </div>

          <Link href="/admissions" className="ajm-button ajm-button-light">
            Apply for Admission <ArrowUpRight size={17} />
          </Link>
        </div>

        <div className="ajm-contact-art" data-reveal>
          <div className="ajm-contact-orbit">
            <span />
            <span />
            <GraduationCap size={64} strokeWidth={1} />
            <small>LEARN · LEAD · BELONG</small>
          </div>
          <div className="ajm-contact-art-foot">
            EVERY LEARNER HAS A STORY <Sparkles size={16} />
          </div>
        </div>
      </div>
    </section>
  );
}

export default function Home() {
  useReveal();

  return (
    <main id="top" className="ajm-premium-home">
      <Announcement />
      <Hero />
      <QuickAccess />
      <Story />
      <ValuesMarquee />

      <section className="ajm-promise">
        <div className="ajm-promise-orbit" />
        <div className="ajm-promise-content" data-reveal>
          <span className="ajm-promise-icon">
            <GraduationCap size={29} />
          </span>
          <span className="ajm-kicker">A PROMISE THAT GUIDES US</span>
          <h2>
            A strong foundation for a
            <br />
            <em>life of possibility.</em>
          </h2>
          <p>
            The future is not simply something to prepare for. It is something
            to help shape.
          </p>
          <Link href="/academics" className="ajm-underlined">
            Explore learning at AJM <ArrowUpRight size={16} />
          </Link>
        </div>
      </section>

      <Campus />
      <Contact />

      <div className="ajm-clock-dock">
        <SchoolClock />
      </div>
    </main>
  );
}
