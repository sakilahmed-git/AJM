
import Link from "next/link";
import {
  ArrowLeft,
  ArrowUpRight,
  CalendarDays,
  BookOpen,
  Image as ImageIcon,
  ChartNoAxesColumnIncreasing,
  Wallet,
  MapPin,
  Users,
  School,
} from "lucide-react";
import ExamCalendar from "@/components/ExamCalendar";

const config = {
  academics: {
    eyebrow: "LEARNING AT AJM",
    title: "A foundation for every future.",
    intro:
      "Discover our school, the people who guide us, and the community that makes learning meaningful.",
    icon: BookOpen,
    sections: [
      ["Strong foundations", "Build the knowledge and habits that help students move forward with confidence."],
      ["Learning with purpose", "Make room for questions, practical understanding and meaningful progress."],
      ["Growing together", "Support students as learners, classmates and responsible members of their community."],
    ],
  },
  "exam-dates": {
    eyebrow: "PLAN WITH CONFIDENCE",
    title: "The exam calendar.",
    intro: "Select your class to see scheduled exams, subjects and dates.",
    icon: CalendarDays,
    sections: [
      ["Class-wise schedules", "Choose your class to view its timetable."],
      ["Prepare ahead", "Plan revision around the published exam dates."],
      ["Need clarification?", "Contact the school office if a schedule needs confirmation."],
    ],
  },
  results: {
    eyebrow: "CELEBRATING PROGRESS",
    title: "Student results.",
    intro:
      "Academic progress is a journey. Use the school's official results process to find the information available for your class.",
    icon: ChartNoAxesColumnIncreasing,
    sections: [
      ["Official updates", "Results should be published only after school verification."],
      ["Student privacy", "Personal academic information must be accessed through a secure, authorised process."],
      ["Need help?", "Contact the school if you need help locating an official result."],
    ],
  },
  fees: {
    eyebrow: "FEE INFORMATION",
    title: "Clarity for every step.",
    intro:
      "For fee schedules, payment status and receipts, please use the school's confirmed process.",
    icon: Wallet,
    sections: [
      ["Understand the schedule", "Check the applicable class and academic year before making a payment."],
      ["Safe payments", "Only pay through a payment method confirmed by the school."],
      ["Receipts and support", "Keep your payment receipt and contact the office if you need help."],
    ],
  },
  gallery: {
    eyebrow: "SCHOOL LIFE, IN FRAMES",
    title: "A little look around.",
    intro:
      "The everyday moments that make a school: learning, friendships, celebrations and people who help us grow.",
    icon: ImageIcon,
    sections: [],
  },
} as const;

type PageKey = keyof typeof config;

const governingBody = [
  {
    name: "Mrs. Rashida Khatun",
    role: "Chairperson",
    image: "/Untitled-design-2024-12-19T133632.252.png",
  },
  {
    name: "Aftab Uddin Sheikh",
    role: "Principal",
    image: "/Untitled-design-2024-12-19T133743.561%20(1).png",
  },
  {
    name: "Islam Uddin Sheikh",
    role: "Managing Trustee",
    image: "/Untitled-design-2024-12-19T133814.258.png",
  },
];

const staff = [
  { name: "Md Atikur Rahman", role: "Vice Principal", image: "WhatsApp%20Image%202025-07-09%20at%2023.26.31_a0147a01.jpg" },
  { name: "Sonalikha Borgoyary", role: "Assistant Teacher", image: "WhatsApp%20Image%202025-07-10%20at%2006.49.00_aa871ba0.jpg" },
  { name: "Gauri Shankar Shaw", role: "Assistant Teacher", image: "WhatsApp%20Image%202025-07-10%20at%2007.44.50_5e14cb70.jpg" },
  { name: "Menaka Sarkar", role: "Assistant Teacher", image: "WhatsApp%20Image%202025-07-10%20at%2007.42.10_1a89917b.jpg" },
  { name: "Md Tajimul Islam", role: "Assistant Teacher", image: "WhatsApp%20Image%202025-07-09%20at%2023.15.30_6ef649e9.jpg" },
  { name: "Rashida Begum", role: "Assistant Teacher", image: "WhatsApp%20Image%202025-07-09%20at%2023.16.34_809715f6.jpg" },
  { name: "Shukla Das", role: "Accountant", image: "WhatsApp%20Image%202025-07-10%20at%2007.51.25_b719815b.jpg" },
  { name: "Saddam Hussain", role: "Assistant Teacher", image: "WhatsApp%20Image%202025-07-09%20at%2023.16.02_0391f9d4.jpg" },
  { name: "Marufa Begum", role: "Assistant Teacher", image: "WhatsApp%20Image%202025-07-10%20at%2007.49.15_fe380ed3.jpg" },
  { name: "Emran Hussain", role: "Assistant Teacher", image: "WhatsApp%20Image%202025-07-09%20at%2023.21.53_d0131d04.jpg" },
  { name: "Rashidul Islam", role: "Assistant Teacher", image: "WhatsApp%20Image%202025-07-10%20at%2007.35.10_ab00371b.jpg" },
  { name: "Basir Uddin Sk", role: "Assistant Teacher", image: "WhatsApp%20Image%202025-07-09%20at%2023.24.14_69773bc5.jpg" },
];

function AcademicsContent() {
  return (
    <div className="academics-content">
      <section className="academics-glance" id="school-glance">
        <div className="academics-section-heading">
          <span className="section-kicker">GET TO KNOW US</span>
          <h2>AJM, <em>at a glance.</em></h2>
          <p>
            A school community rooted in Gossaigaon, Assam, committed to
            meaningful learning, growing confidence and student development.
          </p>
        </div>

        <div className="glance-grid">
          <article className="glance-card">
            <div className="glance-icon"><MapPin size={21} /></div>
            <span>OUR LOCATION</span>
            <h3>Gossaigaon</h3>
            <p>Assam, India</p>
          </article>
          <article className="glance-card">
            <div className="glance-icon"><BookOpen size={21} /></div>
            <span>OUR APPROACH</span>
            <h3>Learn with purpose</h3>
            <p>Building knowledge, curiosity and confidence.</p>
          </article>
          <article className="glance-card">
            <div className="glance-icon"><Users size={21} /></div>
            <span>OUR COMMUNITY</span>
            <h3>Growing together</h3>
            <p>Helping students learn and contribute to their community.</p>
          </article>
        </div>
      </section>

      <section className="academics-story" id="about-ajm">
        <div className="academics-story-mark"><School size={34} strokeWidth={1.3} /></div>
        <div>
          <span className="section-kicker">MORE THAN A CLASSROOM</span>
          <h2>A place to learn, <em>belong and grow.</em></h2>
          <p>
            At AJM English School, education is about more than lessons and
            examinations. It is about developing strong foundations, nurturing
            curiosity and helping every learner move forward with confidence.
            Our school brings together students, educators and leadership in a
            shared commitment to learning.
          </p>
          <Link href="/exam-dates" className="underlined-link">
            Explore exam dates <ArrowUpRight size={15} />
          </Link>
        </div>
      </section>

      <section className="academics-governance" id="governing-body">
        <div className="academics-section-heading">
          <span className="section-kicker">LEADERSHIP & GUIDANCE</span>
          <h2>The people behind <em>our school.</em></h2>
          <p>
            Meet the members of AJM English School&apos;s governing body.
          </p>
        </div>

        <div className="governance-grid">
          {governingBody.map((person, index) => (
            <article className="person-card governance-card" key={person.name}>
              <div className="person-photo">
                <img src={person.image} alt={person.name} loading="lazy" />
                <span>0{index + 1}</span>
              </div>
              <div className="person-info">
                <span className="person-role">{person.role}</span>
                <h3>{person.name}</h3>
              </div>
            </article>
          ))}
        </div>
      </section>

      <section className="academics-staff" id="our-staff">
        <div className="academics-section-heading">
          <span className="section-kicker">THE PEOPLE WHO HELP US GROW</span>
          <h2>Meet our <em>team.</em></h2>
          <p>
            The educators and staff who contribute to our school&apos;s learning
            environment.
          </p>
        </div>

        <div className="staff-grid">
          {staff.map((person) => (
            <article className="person-card staff-card" key={person.name}>
              <div className="person-photo">
                <img
                  src={`/teachers/${person.image}`}
                  alt={person.name}
                  loading="lazy"
                />
              </div>
              <div className="person-info">
                <h3>{person.name}</h3>
                <span className="person-role">{person.role}</span>
              </div>
            </article>
          ))}
        </div>
      </section>

      <section className="academics-explore">
        <div className="academics-section-heading">
          <span className="section-kicker">KEEP EXPLORING</span>
          <h2>Everything you need, <em>in one place.</em></h2>
        </div>
        <div className="academics-quick-links">
          <Link href="/exam-dates"><CalendarDays size={18} /><span><strong>Exam dates</strong><small>Plan the term ahead</small></span><ArrowUpRight size={16} /></Link>
          <Link href="/results"><ChartNoAxesColumnIncreasing size={18} /><span><strong>Student results</strong><small>Follow academic progress</small></span><ArrowUpRight size={16} /></Link>
          <Link href="/fees"><Wallet size={18} /><span><strong>Fee information</strong><small>Find fee guidance</small></span><ArrowUpRight size={16} /></Link>
          <Link href="/gallery"><ImageIcon size={18} /><span><strong>School gallery</strong><small>See moments from school life</small></span><ArrowUpRight size={16} /></Link>
        </div>
      </section>
    </div>
  );
}

export default async function InformationPage({
  params,
}: {
  params: Promise<{ slug: string }>;
}) {
  const { slug } = await params;

  if (!(slug in config)) {
    return (
      <main className="subpage">
        <div className="eyebrow">404 · PAGE NOT FOUND</div>
        <h1>That page wandered <em>off campus.</em></h1>
        <Link className="button button-dark" href="/">
          Back home <ArrowLeft size={16} />
        </Link>
      </main>
    );
  }

  const key = slug as PageKey;
  const page = config[key];
  const Icon = page.icon;

  return (
    <main className="subpage">
      
      <div className="subpage-hero">
        
        <div className="subpage-copy">
          
          <div className="eyebrow">
            <span className="eyebrow-line" />
            {page.eyebrow}
          </div>
          <h1>{page.title}</h1>
          <p>{page.intro}</p>
          {key === "academics" ? (
            <div className="academics-hero-links">
              <a href="#school-glance">School at a glance</a>
              <a href="#governing-body">Leadership</a>
              <a href="#our-staff">Our team</a>
            </div>
          ) : null}
          
        </div>
        <div className="subpage-symbol">
          <Icon size={68} strokeWidth={1} />
          <span>AJM / SCHOOL PORTAL</span>
        </div>
      </div>

      {key === "academics" ? (
        <AcademicsContent />
      ) : key === "exam-dates" ? (
        <ExamCalendar />
      ) : key === "gallery" ? (
        <div className="gallery-grid">
          {[
            "/uploads/20250701_122201.jpg",
            "/uploads/20250701_122231.jpg",
            "/uploads/20250701_122252.jpg",
            "/uploads/WhatsApp%20Image%202025-07-08%20at%2011.42.48_2465c976.jpg",
            "/uploads/WhatsApp%20Image%202025-07-08%20at%2011.45.01_6c3317e3.jpg",
            "/uploads/WhatsApp%20Image%202025-07-08%20at%2011.49.58_d97ddf9f.jpg",
          ].map((src, i) => (
            <div className="gallery-item" key={src}>
              <img
                src={src}
                alt={`AJM English School moment ${i + 1}`}
                loading="lazy"
              />
              <span>AJM MOMENTS / {String(i + 1).padStart(2, "0")}</span>
            </div>
          ))}
        </div>
      ) : (
        <div className="info-cards">
          {page.sections.map(([title, copy], i) => (
            <article className="info-card" key={title}>
              <span>0{i + 1}</span>
              <h2>{title}</h2>
              <p>{copy}</p>
            </article>
          ))}
        </div>
      )}

      <section className="subpage-help">
        <div>
          <span className="section-kicker">WE&apos;RE HERE TO HELP</span>
          <h2>Need a little <em>guidance?</em></h2>
        </div>
        <Link className="button button-dark" href="/#contact">
          Contact the school <ArrowUpRight size={16} />
        </Link>
      </section>
    </main>
  );
}
