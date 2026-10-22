<?php

namespace Database\Seeders;

use App\Models\ContentItem;
use App\Models\ContentText;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedTexts();
        $this->seedItems();
    }

    private function text(string $page, string $key, string $label, string $value, string $type = 'text', int $sort = 0): void
    {
        ContentText::query()->updateOrCreate(
            ['page' => $page, 'key' => $key],
            ['label' => $label, 'value' => $value, 'type' => $type, 'sort_order' => $sort]
        );
    }

    private function seedTexts(): void
    {
        // Global / company info
        $this->text('global', 'company_name', 'Company name', 'Unite Systems');
        $this->text('global', 'company_legal', 'Legal name', 'Unite Systems LLC');
        $this->text('global', 'company_phone', 'Phone number', '855-792-1297');
        $this->text('global', 'company_phone_href', 'Phone link', 'tel:+18557921297', 'url');
        $this->text('global', 'company_email', 'Public email', 'info@unitesystemsllc.com');
        $this->text('global', 'company_hq', 'Headquarters', 'Kentucky, USA');
        $this->text('global', 'company_presence', 'Presence', 'USA and India');
        $this->text('global', 'company_tagline', 'Tagline', 'Transforming healthcare through exceptional talent partnerships and innovative staffing solutions nationwide.', 'textarea');
        $this->text('global', 'footer_note', 'Footer legal note', 'Equal Opportunity Employer.');
        $this->text('global', 'nav_cta_label', 'Header button label', 'Let’s Connect');
        $this->text('global', 'nav_cta_href', 'Header button link', '/contact', 'url');

        // Home
        $this->text('home', 'hero_badge', 'Hero badge', 'Healthcare workforce solutions');
        $this->text('home', 'hero_title', 'Hero title', 'The right healthcare talent, when patient care depends on it.');
        $this->text('home', 'hero_intro', 'Hero intro', 'Unite Systems connects hospitals, clinics and care facilities with pre-screened nursing, allied health and healthcare IT professionals — experienced recruiters, backed by modern sourcing technology.', 'textarea');
        $this->text('home', 'hero_primary_cta_label', 'Primary button label', 'Find Healthcare Talent');
        $this->text('home', 'hero_primary_cta_href', 'Primary button link', '#employers', 'url');
        $this->text('home', 'hero_secondary_cta_label', 'Secondary button label', 'Browse Open Jobs');
        $this->text('home', 'hero_secondary_cta_href', 'Secondary button link', '/jobs', 'url');
        $this->text('home', 'hero_pro_link_label', 'Professional link label', 'Healthcare professional? Create your profile');
        $this->text('home', 'hero_pro_link_href', 'Professional link href', '/register', 'url');
        $this->text('home', 'hero_image', 'Hero image', '', 'image');

        $this->text('home', 'challenges_eyebrow', 'Challenges — eyebrow', 'The challenge');
        $this->text('home', 'challenges_title', 'Challenges — title', 'Healthcare workforce challenges shouldn’t slow patient care.');
        $this->text('home', 'challenges_intro', 'Challenges — intro', 'Every unfilled shift lands on the people already at the bedside. We take the staffing pressure off your team so they can focus on patients.', 'textarea');
        $this->text('home', 'challenges_help_label', 'Challenges — "how we help" label', 'How we help');

        $this->text('home', 'solutions_eyebrow', 'Solutions — eyebrow', 'Solutions');
        $this->text('home', 'solutions_title', 'Solutions — title', 'Staffing built around how care is actually delivered.');
        $this->text('home', 'solutions_intro', 'Solutions — intro', 'From one urgent shift to a permanent hire, plus specialist recruiting for pharmaceutical and IT teams.', 'textarea');
        $this->text('home', 'solutions_link_label', 'Solutions — link label', 'Discuss this solution');

        $this->text('home', 'process_eyebrow', 'Process — eyebrow', 'How Unite Systems works');
        $this->text('home', 'process_title', 'Process — title', 'Four steps from requirement to a filled role.');
        $this->text('home', 'process_intro', 'Process — intro', 'A clear, accountable process, with one team responsible from the first conversation to ongoing support.', 'textarea');

        $this->text('home', 'professionals_eyebrow', 'Professionals — eyebrow', 'For healthcare professionals');
        $this->text('home', 'professionals_title', 'Professionals — title', 'Your expertise deserves the right opportunity.');
        $this->text('home', 'professionals_intro', 'Professionals — intro', 'Travel, contract, temp-to-hire or permanent, with a recruiter who knows your specialty and stays with you after placement.', 'textarea');
        $this->text('home', 'professionals_primary_cta_label', 'Professionals — primary button', 'Browse Open Jobs');
        $this->text('home', 'professionals_primary_cta_href', 'Professionals — primary link', '/jobs', 'url');
        $this->text('home', 'professionals_secondary_cta_label', 'Professionals — secondary button', 'Create Your Profile');
        $this->text('home', 'professionals_secondary_cta_href', 'Professionals — secondary link', '/register', 'url');
        $this->text('home', 'professionals_specialties_label', 'Professionals — specialties label', 'Specialties we place');

        $this->text('home', 'employers_eyebrow', 'Employers — eyebrow', 'For employers');
        $this->text('home', 'employers_title', 'Employers — title', 'Build a workforce that keeps care moving.');
        $this->text('home', 'employers_intro', 'Employers — intro', 'Flexible, pre-screened talent and one accountable partner, so your teams stay staffed and focused on patients.', 'textarea');
        $this->text('home', 'employers_primary_cta_label', 'Employers — button', 'Find Workforce Solutions');
        $this->text('home', 'employers_primary_cta_href', 'Employers — link', '/contact', 'url');
        $this->text('home', 'employers_sectors_label', 'Employers — sectors label', 'From Fortune 1000 firms to mid-sized businesses in');

        $this->text('home', 'testimonials_eyebrow', 'Testimonials — eyebrow', 'Testimonials');
        $this->text('home', 'testimonials_title', 'Testimonials — title', 'Trusted by the people we place.');

        $this->text('home', 'insights_eyebrow', 'Insights — eyebrow', 'Insights');
        $this->text('home', 'insights_title', 'Insights — title', 'Guidance for care leaders and clinicians.');
        $this->text('home', 'insights_link_label', 'Insights — link label', 'View all insights');

        $this->text('home', 'final_cta_title', 'Final CTA — title', 'Let’s build a stronger healthcare workforce together.');
        $this->text('home', 'final_cta_intro', 'Final CTA — intro', 'Tell us about the roles you need to fill, or the role you want next. A recruiter will respond with a clear plan.', 'textarea');
        $this->text('home', 'final_cta_primary_label', 'Final CTA — primary button', 'Talk to Unite Systems');
        $this->text('home', 'final_cta_primary_href', 'Final CTA — primary link', '/contact', 'url');
        $this->text('home', 'final_cta_secondary_label', 'Final CTA — secondary button', 'Browse Open Jobs');
        $this->text('home', 'final_cta_secondary_href', 'Final CTA — secondary link', '/jobs', 'url');

        // About
        $this->text('about', 'hero_eyebrow', 'Hero — eyebrow', 'About Unite Systems');
        $this->text('about', 'hero_title', 'Hero — title', 'Putting patient care at the heart of staffing.');
        $this->text('about', 'hero_intro', 'Hero — intro', 'A fast-growing healthcare staffing partner, guided by leaders with more than 18 years of healthcare and staffing experience.', 'textarea');
        $this->text('about', 'story_eyebrow', 'Story — eyebrow', 'Our story');
        $this->text('about', 'story_title', 'Story — title', 'At Unite Systems, we tell it like it is.');
        $this->text('about', 'story_body', 'Story — body', implode('', array_map(fn ($p) => '<p>'.$p.'</p>', [
            'Unite Systems is a dynamic, fast-growing healthcare staffing partner committed to excellence across a wide range of staffing solutions. We connect skilled healthcare professionals with hospitals, clinics and care facilities across the United States — providing full-time, part-time, contract, temp-to-hire and urgent placement services.',
            'Guided by a leadership team with more than 18 years of experience in healthcare and staffing, we combine proven expertise with a fresh, agile approach to evolving workforce needs.',
            'With a presence in the USA and India, we pair global reach with local expertise. Our recruiters work at the intersection of people, process and technology to deliver progressive, reliable and sustainable staffing for healthcare organizations and professionals alike.',
            'We understand the challenges facing healthcare organizations today, and we are committed to being a partner that tells it like it is.',
        ])), 'richtext');
        $this->text('about', 'mission', 'Mission', 'To transform healthcare delivery by strategically uniting top-tier professionals with forward-thinking healthcare institutions — ensuring exceptional patient outcomes, operational excellence and long-term organizational growth.', 'textarea');
        $this->text('about', 'vision', 'Vision', 'To be the nation’s leading healthcare staffing partner — renowned for transforming lives, empowering careers and elevating healthcare standards through innovation, integrity and excellence.', 'textarea');
        $this->text('about', 'values_eyebrow', 'Values — eyebrow', 'Core values');
        $this->text('about', 'values_title', 'Values — title', 'The principles behind every placement.');
        $this->text('about', 'why_eyebrow', 'Why — eyebrow', 'Why Unite Systems');
        $this->text('about', 'why_title', 'Why — title', 'A staffing partner that tells it like it is.');
        $this->text('about', 'why_intro', 'Why — intro', 'A dynamic, fast-growing healthcare staffing partner, guided by leaders with deep healthcare and staffing experience, and built on integrity, people, diversity, growth and respect.', 'textarea');
        $this->text('about', 'locations_eyebrow', 'Locations — eyebrow', 'Where we work');
        $this->text('about', 'locations_title', 'Locations — title', 'Local expertise, global reach.');

        // Services
        $this->text('services', 'hero_eyebrow', 'Hero — eyebrow', 'Industries & services');
        $this->text('services', 'hero_title', 'Hero — title', 'Healthcare at our core. Expertise beyond it.');
        $this->text('services', 'hero_intro', 'Hero — intro', 'Specialized staffing for healthcare, pharmaceuticals and information technology, with flexible models from urgent coverage to permanent placement.', 'textarea');
        $this->text('services', 'specialties_eyebrow', 'Specialties — eyebrow', 'Specialties we place');
        $this->text('services', 'specialties_title', 'Specialties — title', 'From the bedside to the back office.');
        $this->text('services', 'specialties_intro', 'Specialties — intro', 'A wide range of clinical and non-clinical professionals — and many more roles across sectors to meet your needs.', 'textarea');

        // Jobs
        $this->text('jobs', 'hero_eyebrow', 'Hero — eyebrow', 'Careers');
        $this->text('jobs', 'hero_title', 'Hero — title', 'Find your next healthcare role.');
        $this->text('jobs', 'hero_intro', 'Hero — intro', 'Travel, contract, temp-to-hire and permanent opportunities with respected healthcare organizations across the United States.', 'textarea');
        $this->text('jobs', 'empty_title', 'Empty state — title', 'No open roles match your search right now.');
        $this->text('jobs', 'empty_text', 'Empty state — text', 'Create a profile and our recruiters will contact you when a matching role opens.', 'textarea');
        $this->text('jobs', 'register_prompt_title', 'Register prompt — title', 'Applying to more than one role?');
        $this->text('jobs', 'register_prompt_text', 'Register prompt — text', 'Create a free profile once — upload your resume and preferences — then apply to any job in one click.', 'textarea');

        // Register
        $this->text('register', 'title', 'Title', 'Create your candidate profile');
        $this->text('register', 'intro', 'Intro', 'Register once to apply to multiple jobs, and let our recruiters match you with roles that fit your skills and preferred locations.', 'textarea');
        $this->text('register', 'eeo_note', 'EEO note', 'Unite Systems is an Equal Opportunity Employer. Answering the disability question is voluntary and will not affect your application. It is kept separate from your profile and is not used in hiring decisions.', 'textarea');

        // Contact
        $this->text('contact', 'hero_eyebrow', 'Hero — eyebrow', 'Let’s work together');
        $this->text('contact', 'hero_title', 'Hero — title', 'Tell us what you need. We’ll take it from there.');
        $this->text('contact', 'hero_intro', 'Hero — intro', 'Request healthcare talent for your facility, or share your details to explore your next role. A recruiter will respond with a clear plan.', 'textarea');
        $this->text('contact', 'office_hours', 'Office hours', 'Monday–Friday, 9am–6pm ET');

        // Privacy
        $this->text('privacy', 'effective_date', 'Effective date', 'January 1, 2026');
        $this->text('privacy', 'body', 'Policy body', $this->privacyHtml(), 'richtext');
    }

    private function privacyHtml(): string
    {
        $sections = [
            ['Overview', [
                'Unite Systems LLC (“Unite Systems”, “we”, “us”) respects your privacy. This policy explains what information we collect through our website and recruiting services, how we use and share it, and the choices you have.',
                'It applies to visitors of our website, healthcare professionals and other candidates who apply through us, and representatives of the organizations we serve.',
            ], []],
            ['Information we collect', ['Information you give us, such as:'], [
                'Contact details — name, email address, phone number and location.',
                'Candidate information — resume, work history, specialty, licenses and certifications, availability and job preferences.',
                'Employer information — organization name, role requirements and staffing needs.',
                'Messages you send us through forms, email, phone or text.',
            ]],
            ['How we use your information', [], [
                'To respond to enquiries and provide our staffing and recruiting services.',
                'To match candidates with suitable opportunities and present qualified candidates to client organizations.',
                'To verify qualifications and complete onboarding requirements where applicable.',
                'To communicate with you about your application, assignment or request, including by phone, email and text message.',
                'To operate, secure and improve our website and services.',
                'To comply with legal obligations and protect our rights.',
            ]],
            ['How we share information', ['We do not sell your personal information. We share it only as needed to provide our services:'], [
                'With healthcare facilities and client organizations when presenting you for an opportunity you are interested in.',
                'With service providers who support our operations (for example hosting, email and applicant-tracking tools), under confidentiality obligations.',
                'When required by law, legal process or to protect the rights, property or safety of Unite Systems, our clients or others.',
            ]],
            ['Text messaging (SMS)', [
                'By providing a phone number and submitting a form, you consent to be contacted by SMS text message about your request or application. Message and data rates may apply. Message frequency may vary.',
                'You can opt out at any time by replying STOP, and get help by replying HELP. Mobile information will not be shared with third parties or affiliates for marketing or promotional purposes, and SMS opt-in data and consent will not be shared with any third parties.',
            ], []],
            ['Cookies and analytics', ['We may use cookies and analytics tools to understand how visitors use our website and to improve it. You can control cookies through your browser settings; some features may not work without them.'], []],
            ['Data retention and security', [
                'We keep personal information for as long as needed for the purposes described in this policy, including to consider you for future opportunities, unless you ask us to delete it or the law requires otherwise.',
                'We use reasonable administrative, technical and physical safeguards to protect your information. No method of transmission or storage is completely secure.',
            ], []],
            ['Your choices and rights', ['You may ask us to access, correct or delete your personal information, or to stop contacting you. Depending on where you live, you may have additional rights under state law. To make a request, contact us using the details below.'], []],
            ['Children’s privacy', ['Our website and services are intended for adults. We do not knowingly collect personal information from children under 16.'], []],
            ['Links to other websites', ['Our website may link to websites we do not operate. Their privacy practices are governed by their own policies.'], []],
            ['Changes to this policy', ['We may update this policy from time to time. We will post the updated version on this page with a new effective date.'], []],
        ];

        $html = '';
        foreach ($sections as [$title, $paragraphs, $list]) {
            $html .= '<h3>'.$title.'</h3>';
            foreach ($paragraphs as $p) {
                $html .= '<p>'.$p.'</p>';
            }
            if ($list) {
                $html .= '<ul>'.implode('', array_map(fn ($i) => '<li>'.$i.'</li>', $list)).'</ul>';
            }
        }

        return $html;
    }

    private function items(string $group, array $rows): void
    {
        ContentItem::query()->where('group', $group)->delete();

        foreach ($rows as $i => $row) {
            ContentItem::query()->create($row + ['group' => $group, 'sort_order' => $i, 'active' => true]);
        }
    }

    private function seedItems(): void
    {
        $this->items('nav_main', [
            ['title' => 'Home', 'extra_text' => '/'],
            ['title' => 'About Us', 'extra_text' => '/about'],
            ['title' => 'Services', 'extra_text' => '/services'],
            ['title' => 'Jobs', 'extra_text' => '/jobs'],
            ['title' => 'Employers', 'extra_text' => '#employers'],
            ['title' => 'Professionals', 'extra_text' => '#professionals'],
            ['title' => 'Contact Us', 'extra_text' => '/contact'],
        ]);

        $this->items('home_trust', [
            ['icon' => 'HeartPulse', 'title' => 'Nursing, allied & health IT', 'body' => 'Clinical and non-clinical professionals'],
            ['icon' => 'Layers', 'title' => 'Every staffing model', 'body' => 'Travel, contract, temp-to-hire, permanent'],
            ['icon' => 'ShieldCheck', 'title' => 'Pre-screened talent', 'body' => 'Vetted and matched to your requirements'],
            ['icon' => 'Handshake', 'title' => 'Dedicated account management', 'body' => 'One accountable point of contact'],
            ['icon' => 'Compass', 'title' => '18+ years of leadership', 'body' => 'Healthcare staffing experience, USA and India'],
        ]);

        $this->items('home_challenges', [
            ['icon' => 'Users', 'title' => 'Talent shortages', 'body' => 'Qualified nurses and technologists are hard to find, and harder to keep.', 'extra_text' => 'A pre-screened network of nursing and allied professionals, plus our in-house sourcing platform.'],
            ['icon' => 'Clock', 'title' => 'Time-to-fill pressure', 'body' => 'Every open shift puts pressure on teams and patient care.', 'extra_text' => 'Urgent placement support and local recruiters who already know the talent in your market.'],
            ['icon' => 'ShieldCheck', 'title' => 'Compliance complexity', 'body' => 'Licenses, certifications and documentation must be right before day one.', 'extra_text' => 'Candidates screened and matched to your facility’s requirements before they’re presented.'],
            ['icon' => 'TrendingUp', 'title' => 'Workforce scalability', 'body' => 'Census, seasons and projects change faster than hiring cycles.', 'extra_text' => 'Flexible models, from a few weeks of coverage to permanent hires and interim leadership.'],
        ]);

        $this->items('home_solutions', [
            ['icon' => 'Stethoscope', 'title' => 'Healthcare Staffing', 'body' => 'The widest range of nurse and clinical staffing, with specialties and assignment lengths customized to your facility.', 'points' => ['Nurse staffing', 'Travel nurse staffing', 'Allied health staffing', 'Physician staffing'], 'featured' => true],
            ['icon' => 'Layers', 'title' => 'Flexible Workforce Solutions', 'body' => 'Coverage that flexes with demand — full-time, part-time, contract, temp-to-hire and urgent placements.', 'points' => ['Contract', 'Temp-to-hire', 'Urgent placement']],
            ['icon' => 'UserCheck', 'title' => 'Talent Acquisition', 'body' => 'Permanent placement for nurses, allied professionals and physicians who fit your culture.', 'points' => ['Permanent placement', 'Physician placement']],
            ['icon' => 'BadgeCheck', 'title' => 'Interim Nurse Leadership', 'body' => 'Experienced nurse leaders to steady a unit through transitions and vacancies.', 'points' => ['Interim leadership', 'Leadership transitions']],
            ['icon' => 'FlaskConical', 'title' => 'Pharma & IT Staffing', 'body' => 'Specialist recruiters for pharmaceutical, life sciences and information technology teams.', 'points' => ['R&D and regulatory', 'Quality assurance', 'Project management']],
        ]);

        $this->items('home_process', [
            ['icon' => 'Search', 'subtitle' => '01', 'title' => 'Understand', 'body' => 'We learn your roles, shift patterns, assignment lengths, culture and compliance requirements.'],
            ['icon' => 'Users', 'subtitle' => '02', 'title' => 'Match', 'body' => 'We source from our pre-screened network and in-house platform, matching for skills and fit.'],
            ['icon' => 'Rocket', 'subtitle' => '03', 'title' => 'Mobilize', 'body' => 'We coordinate onboarding so your professional is ready to start on time.'],
            ['icon' => 'LifeBuoy', 'subtitle' => '04', 'title' => 'Support', 'body' => 'We stay close through every assignment and step in promptly if challenges arise.'],
        ]);

        $this->items('professional_benefits', [
            ['icon' => 'Briefcase', 'title' => 'Job opportunities', 'body' => 'Travel, contract, temp-to-hire and permanent roles with respected healthcare organizations.'],
            ['icon' => 'GraduationCap', 'title' => 'Career support', 'body' => 'An experienced healthcare recruiter who understands your specialty.'],
            ['icon' => 'Compass', 'title' => 'Placement assistance', 'body' => 'Help finding assignments that fit your skills, location and goals.'],
            ['icon' => 'FileCheck2', 'title' => 'Credentialing support', 'body' => 'Guidance getting your documentation in order before day one.'],
            ['icon' => 'HeartHandshake', 'title' => 'An ongoing relationship', 'body' => 'Support that continues after placement, not just until you sign.'],
        ]);

        $this->items('employer_points', [
            ['icon' => 'Building2', 'title' => 'Staffing support', 'body' => 'Nursing, allied, physician and healthcare IT coverage.'],
            ['icon' => 'Zap', 'title' => 'Faster access to qualified talent', 'body' => 'Pre-screened candidates from a ready network.'],
            ['icon' => 'Layers', 'title' => 'Workforce flexibility', 'body' => 'Scale up or down with contract, temp-to-hire and permanent models.'],
            ['icon' => 'ShieldCheck', 'title' => 'Compliance support', 'body' => 'Candidates matched to your requirements before presentation.'],
            ['icon' => 'Handshake', 'title' => 'Dedicated partnership', 'body' => 'An account manager who owns your requirements end to end.'],
        ]);

        $this->items('employer_sectors', [
            ['title' => 'Healthcare'],
            ['title' => 'Pharmaceutical & life sciences'],
            ['title' => 'Financial services'],
            ['title' => 'Insurance'],
            ['title' => 'Telecom & utilities'],
            ['title' => 'Manufacturing'],
        ]);

        $this->items('principles', [
            ['icon' => 'HeartHandshake', 'title' => 'People-first', 'body' => 'Integrity, respect and relationships that last beyond placement.'],
            ['icon' => 'Stethoscope', 'title' => 'Healthcare-focused', 'body' => 'Recruiters who understand clinical roles and patient care.'],
            ['icon' => 'Zap', 'title' => 'Responsive', 'body' => 'Management that steps in promptly when challenges arise.'],
            ['icon' => 'ShieldCheck', 'title' => 'Compliance-conscious', 'body' => 'Talent screened and matched before it reaches you.'],
            ['icon' => 'Cpu', 'title' => 'Technology-enabled', 'body' => 'An in-house sourcing platform behind every search.'],
            ['icon' => 'Handshake', 'title' => 'Partnership-driven', 'body' => 'Dedicated account management and transparent communication.'],
        ]);

        $this->items('about_facts', [
            ['title' => 'Headquartered', 'body' => 'Kentucky, USA'],
            ['title' => 'Teams in', 'body' => 'USA and India'],
            ['title' => 'Leadership experience', 'body' => '18+ years'],
            ['title' => 'Clients from', 'body' => 'Fortune 1000 to mid-sized'],
        ]);

        $this->items('testimonials', [
            ['title' => 'Felix Collazo', 'subtitle' => 'X-ray Technologist, Louisville, KY', 'body' => 'Working with Unite Systems has been an incredibly rewarding experience. I’ve had the privilege of serving the most respected healthcare organizations. When challenges arise, management steps in promptly with unwavering support and resolution.'],
            ['title' => 'Client name', 'subtitle' => 'Title, facility', 'body' => 'Placeholder — add a verified quote from a hospital or clinic partner about quality, speed and support.', 'featured' => true],
            ['title' => 'Professional name', 'subtitle' => 'Specialty, city', 'body' => 'Placeholder — add a verified quote from a nurse or allied professional about their recruiter experience.', 'featured' => true],
        ]);

        $this->items('insights', [
            ['subtitle' => 'Healthcare staffing', 'title' => 'Contract, temp-to-hire or permanent: choosing the right model', 'body' => 'How to match your staffing model to census, budget and timeline.'],
            ['subtitle' => 'Workforce trends', 'title' => 'Allied health roles facilities are hiring for now', 'body' => 'Imaging, cardiovascular and laboratory roles in focus.'],
            ['subtitle' => 'Career advice', 'title' => 'Preparing for your first travel assignment', 'body' => 'What to organize before day one, from credentials to logistics.'],
            ['subtitle' => 'Industry resources', 'title' => 'A credentialing checklist for new placements', 'body' => 'The documents to have ready so onboarding goes smoothly.'],
        ]);

        $this->items('specialties', collect([
            'Registered Nurse', 'Physician Assistant', 'Radiography', 'Radiation Therapy', 'CT Technologist',
            'Angiographer', 'Cardiac Cath Radiographer', 'Vascular Technologist', 'Cardiovascular Tech',
            'Clinical Laboratory Scientist', 'Anesthesiologist Assistant', 'Certified Surgical Assistant',
            'EHR IS/IT Manager', 'Health Information Management', 'Medical Billing', 'Front Desk Associate',
        ])->map(fn ($name) => ['title' => $name])->all());

        $this->items('specialty_groups', [
            ['title' => 'Nursing & advanced practice', 'points' => ['Registered Nurse', 'Physician Assistant', 'Anesthesiologist Assistant', 'Certified Surgical Assistant']],
            ['title' => 'Imaging & cardiovascular', 'points' => ['Radiography', 'Radiation Therapy Technology', 'CT (Cat Scan) Technologist', 'Angiographer', 'Cardiac Cath Radiographer', 'Registered Vascular Technologist', 'Cardiovascular Technologist']],
            ['title' => 'Laboratory & health IT', 'points' => ['Clinical Laboratory Scientist', 'EHR IS/IT Manager', 'Health Information Management', 'Data Entry / DBA']],
            ['title' => 'Clerical & administrative', 'points' => ['Department Physician Coordinator', 'Front Desk Associate', 'Billing', 'Clerical']],
        ]);

        $this->items('industries', [
            ['extra_text' => 'healthcare', 'title' => 'Healthcare', 'subtitle' => 'The widest range of nurse and clinical staffing', 'body' => 'Our nursing specialties and assignment lengths are fully customizable to fit your facility’s needs — from short-term coverage to permanent hires and interim leadership.', 'points' => ['Nurse staffing services', 'Travel nurse staffing', 'Interim nurse leadership', 'Physician staffing services', 'Permanent placement', 'Allied health staffing', 'Permanent physician placement', 'Temporary physician staffing']],
            ['extra_text' => 'pharma', 'title' => 'Pharmaceuticals', 'subtitle' => 'Talent for a regulated, fast-moving industry', 'body' => 'Pharmaceutical and life sciences companies face significant operational and regulatory challenges, constant pressure to innovate, eroding patent protection and fierce competition. We help them acquire and manage the talent they need to differentiate and grow.', 'points' => ['Administrative / clerical', 'Research & development', 'Marketing & communications', 'Regulatory', 'Accounting / finance', 'Information technology', 'Nursing', 'HR / legal', 'Quality assurance', 'Chemistry', 'Biochemistry', 'Supply chain, procurement & logistics', 'Scientific packaging & labels', 'Clinical data', 'Healthcare compliance & privacy']],
            ['extra_text' => 'it', 'title' => 'Information Technology', 'subtitle' => 'Specialist recruiters from the industry', 'body' => 'Information technology moves fast. Our recruiters come from the industry and bring deep domain expertise, helping companies acquire the talent to adapt, meet everyday challenges and capitalize on new opportunities.', 'points' => ['Project management', 'Strategy & operations', 'Testing & quality assurance', 'Data warehousing', 'Regulatory engineering', 'IT training', 'Research & development', 'Sourcing & inventory management', 'Customer service / call center', 'Marketing & communications', 'Accounting / finance', 'HR / legal']],
        ]);

        $this->items('faqs_employers', [
            ['title' => 'What staffing models do you offer?', 'body' => 'Full-time, part-time, contract, temp-to-hire and urgent placements, plus permanent placement and interim nurse leadership. Assignments range from a few weeks to several months.'],
            ['title' => 'How do you vet candidates?', 'body' => 'Every professional in our network is pre-screened and matched to your requirements for skills, cultural fit and commitment before they are presented.'],
            ['title' => 'Can a contract clinician convert to a permanent hire?', 'body' => 'Yes. Our temp-to-hire model lets you evaluate a professional on the job before making a permanent offer.'],
            ['title' => 'Do you staff roles outside healthcare?', 'body' => 'Yes. We also recruit for pharmaceutical and life sciences companies and for information technology teams.'],
        ]);

        $this->items('faqs_professionals', [
            ['title' => 'How do I apply?', 'body' => 'Choose "I’m looking for work" on the form, share your details and attach your resume. A recruiter will contact you about roles that fit.'],
            ['title' => 'What kinds of assignments are available?', 'body' => 'Travel, contract, temp-to-hire and permanent roles, with assignment lengths from a few weeks to several months.'],
            ['title' => 'Will I have a dedicated recruiter?', 'body' => 'Yes. An experienced healthcare recruiter guides you from application through placement, and our management team steps in promptly if challenges arise.'],
        ]);

        $this->items('about_values', [
            ['title' => 'Integrity', 'body' => 'We uphold transparency and honesty in every placement, building lasting trust with clients and candidates.'],
            ['title' => 'People', 'body' => 'We put people first by empowering talent and nurturing strong, respectful relationships.'],
            ['title' => 'Diversity', 'body' => 'We embrace diverse perspectives to deliver inclusive staffing that reflects the communities we serve.'],
            ['title' => 'Growth', 'body' => 'We drive continuous improvement and success for our clients, candidates and team.'],
            ['title' => 'Respect', 'body' => 'Every candidate and every client is treated as a partner.'],
            ['title' => 'National impact', 'body' => 'We connect skilled professionals across the nation to transform industries and improve lives.'],
        ]);

        $this->items('about_locations', [
            ['title' => 'United States', 'body' => 'Headquartered in Kentucky, placing professionals with healthcare facilities nationwide.'],
            ['title' => 'India', 'body' => 'A strong presence that extends our global reach and sourcing capability.'],
        ]);

        $this->items('contact_next_steps', [
            ['body' => 'We review your request or application.'],
            ['body' => 'A recruiter or account manager contacts you to understand your needs.'],
            ['body' => 'We present matched candidates, or opportunities that fit you.'],
        ]);

        $this->items('footer_columns', [
            ['title' => 'Services', 'points' => ['Healthcare Staffing|/services#healthcare', 'Pharmaceuticals|/services#pharma', 'Information Technology|/services#it', 'Staffing Models|/services#models']],
            ['title' => 'Professionals', 'points' => ['Explore Opportunities|#professionals', 'Specialties|/services#specialties', 'Apply Now|/contact']],
            ['title' => 'Employers', 'points' => ['Request Talent|/contact', 'How It Works|#how-it-works', 'Why Unite Systems|/about#why']],
            ['title' => 'Company', 'points' => ['About Us|/about', 'Testimonials|/#testimonials', 'Contact Us|/contact']],
            ['title' => 'Resources', 'points' => ['Jobs|/jobs', 'Privacy Policy|/privacy']],
        ]);
    }
}
