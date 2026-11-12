<?php

namespace Database\Seeders;

use App\Models\ContentItem;
use App\Models\ContentText;
use Illuminate\Database\Seeder;

/**
 * Seeds starter content for the two dedicated services sub-pages
 * (Healthcare, Information Technology) linked from the "Services" nav
 * dropdown. Uses updateOrCreate / safe upserts so it can be re-run without
 * clobbering anything an admin has already edited by hand afterwards.
 */
class ServicesSubpagesSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedPageText('services_healthcare', [
            'hero_eyebrow' => 'Healthcare staffing',
            'hero_title' => 'The widest range of nurse and clinical staffing.',
            'hero_intro' => 'Nursing specialties and assignment lengths fully customizable to fit your facility\'s needs — from short-term coverage to permanent hires and interim leadership.',
            'roles_label' => 'Roles we staff',
            'specialties_eyebrow' => 'Specialties we place',
            'specialties_title' => 'From the bedside to the back office.',
            'specialties_intro' => 'A wide range of clinical and non-clinical healthcare professionals — and many more roles beyond what\'s listed here.',
            'cta_title' => 'Need healthcare talent, fast?',
            'cta_body' => 'Tell us about your staffing needs and a recruiter will respond with a clear plan.',
            'cta_label' => 'Request Talent',
        ]);

        $this->seedPageText('services_it', [
            'hero_eyebrow' => 'Information technology staffing',
            'hero_title' => 'Specialist IT recruiters from the industry.',
            'hero_intro' => 'Information technology moves fast. Our recruiters come from the industry and bring deep domain expertise, helping companies acquire the talent to adapt, meet everyday challenges and capitalize on new opportunities.',
            'roles_label' => 'Roles we staff',
            'specialties_eyebrow' => 'Specialties we place',
            'specialties_title' => 'From infrastructure to the back office.',
            'specialties_intro' => 'A wide range of technology and business-support professionals — and many more roles beyond what\'s listed here.',
            'cta_title' => 'Need IT talent, fast?',
            'cta_body' => 'Tell us about your staffing needs and a recruiter will respond with a clear plan.',
            'cta_label' => 'Request Talent',
        ]);

        $this->seedRoles('services_healthcare_roles', [
            'Nurse staffing services',
            'Travel nurse staffing',
            'Interim nurse leadership',
            'Physician staffing services',
            'Permanent placement',
            'Allied health staffing',
            'Permanent physician placement',
            'Temporary physician staffing',
        ]);

        $this->seedRoles('services_it_roles', [
            'Project management',
            'Strategy & operations',
            'Testing & quality assurance',
            'Data warehousing',
            'Regulatory engineering',
            'IT training',
            'Research & development',
            'Sourcing & inventory management',
            'Customer service / call center',
            'Marketing & communications',
            'Accounting / finance',
            'HR / legal',
        ]);

        $this->seedGroups('services_healthcare_specialties', [
            ['title' => 'Nursing & advanced practice', 'points' => ['Registered Nurse', 'Physician Assistant', 'Anesthesiologist Assistant', 'Certified Surgical Assistant']],
            ['title' => 'Imaging & cardiovascular', 'points' => ['Radiography', 'Radiation Therapy Technology', 'CT (Cat Scan) Technologist', 'Angiographer', 'Cardiac Cath Radiographer', 'Registered Vascular Technologist', 'Cardiovascular Technologist']],
            ['title' => 'Laboratory & health IT', 'points' => ['Clinical Laboratory Scientist', 'EHR IS/IT Manager', 'Health Information Management', 'Data Entry / DBA']],
            ['title' => 'Clerical & administrative', 'points' => ['Department Physician Coordinator', 'Front Desk Associate', 'Billing', 'Clerical']],
        ]);

        $this->seedGroups('services_it_specialties', [
            ['title' => 'Project & delivery', 'points' => ['Project management', 'Strategy & operations', 'Testing & quality assurance']],
            ['title' => 'Data & engineering', 'points' => ['Data warehousing', 'Regulatory engineering', 'Research & development']],
            ['title' => 'Operations & support', 'points' => ['Sourcing & inventory management', 'Customer service / call center', 'IT training']],
            ['title' => 'Business & administration', 'points' => ['Marketing & communications', 'Accounting / finance', 'HR / legal']],
        ]);
    }

    /** @param array<string, string> $fields */
    private function seedPageText(string $page, array $fields): void
    {
        foreach ($fields as $key => $value) {
            ContentText::query()->updateOrCreate(
                ['page' => $page, 'key' => $key],
                ['label' => ucfirst(str_replace('_', ' ', $key)), 'value' => $value, 'type' => 'text']
            );
        }
    }

    /** @param array<int, string> $roles */
    private function seedRoles(string $group, array $roles): void
    {
        if (ContentItem::where('group', $group)->exists()) {
            return;
        }

        foreach ($roles as $i => $title) {
            ContentItem::create([
                'group' => $group,
                'title' => $title,
                'sort_order' => $i,
                'active' => true,
            ]);
        }
    }

    /** @param array<int, array{title: string, points: array<int, string>}> $groups */
    private function seedGroups(string $group, array $groups): void
    {
        if (ContentItem::where('group', $group)->exists()) {
            return;
        }

        foreach ($groups as $i => $row) {
            ContentItem::create($row + ['group' => $group, 'sort_order' => $i, 'active' => true]);
        }
    }
}
