<?php

namespace Database\Seeders;

use App\Models\JobPosting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobPostingSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            [
                'title' => 'Registered Nurse — Med/Surg',
                'category' => 'Nursing',
                'location' => 'Louisville, KY',
                'job_type' => 'Travel',
                'shift' => 'Nights, 3x12',
                'pay' => '$2,100–$2,400/week',
                'summary' => 'Join a respected med/surg unit on a 13-week travel assignment with weekly pay and benefits.',
                'description' => "<p>We're seeking an experienced Med/Surg Registered Nurse for a 13-week travel assignment with a respected hospital partner.</p><p>You'll deliver patient-centered care on a busy medical-surgical unit, working closely with an established care team.</p>",
                'requirements' => ['Active RN license (compact or state-specific)', 'BLS certification', '1+ year recent Med/Surg experience', 'ACLS preferred'],
                'benefits' => ['Weekly pay', 'Travel & housing stipend', 'Medical, dental & vision', 'Dedicated recruiter support'],
                'status' => 'open',
                'featured' => true,
            ],
            [
                'title' => 'ICU Registered Nurse',
                'category' => 'Nursing',
                'location' => 'Lexington, KY',
                'job_type' => 'Contract',
                'shift' => 'Days, 3x12',
                'pay' => '$2,300–$2,600/week',
                'summary' => 'Critical care RN needed for a high-acuity ICU with a supportive, experienced team.',
                'description' => '<p>Deliver advanced critical care to a diverse ICU patient population. Precepting and a thorough unit orientation provided.</p>',
                'requirements' => ['Active RN license', 'BLS & ACLS required', '2+ years ICU experience', 'Ventilator & titratable drip experience'],
                'benefits' => ['Competitive weekly pay', 'Housing assistance', 'Health insurance from day one', '24/7 recruiter support'],
                'status' => 'open',
                'featured' => true,
            ],
            [
                'title' => 'CT Technologist',
                'category' => 'Imaging',
                'location' => 'Indianapolis, IN',
                'job_type' => 'Temp-to-hire',
                'shift' => 'Variable',
                'pay' => '$42–$48/hr',
                'summary' => 'CT Technologist for a growing imaging department, with a clear path to a permanent role.',
                'description' => '<p>Perform CT imaging studies, ensure patient safety and image quality, and collaborate with radiologists and referring physicians.</p>',
                'requirements' => ['ARRT(R)(CT) certification', 'State licensure where required', '1+ year CT experience'],
                'benefits' => ['Competitive hourly pay', 'Path to permanent hire', 'Flexible scheduling'],
                'status' => 'open',
                'featured' => false,
            ],
            [
                'title' => 'Physician Assistant — Family Medicine',
                'category' => 'Physician / PA',
                'location' => 'Cincinnati, OH',
                'job_type' => 'Permanent',
                'shift' => 'Monday–Friday',
                'pay' => 'Competitive, based on experience',
                'summary' => 'Permanent placement for a Physician Assistant in a well-established family medicine practice.',
                'description' => '<p>Provide comprehensive primary care services to patients of all ages in an outpatient clinic setting.</p>',
                'requirements' => ['NCCPA certification', 'Active state PA license', 'DEA registration', 'Family medicine experience preferred'],
                'benefits' => ['Competitive salary', 'Health & retirement benefits', 'Relocation assistance considered'],
                'status' => 'open',
                'featured' => false,
            ],
            [
                'title' => 'Clinical Laboratory Scientist',
                'category' => 'Laboratory',
                'location' => 'Nashville, TN',
                'job_type' => 'Contract',
                'shift' => 'Evenings',
                'pay' => '$38–$44/hr',
                'summary' => 'CLS needed to support a high-volume hospital laboratory on evening shift.',
                'description' => '<p>Perform clinical laboratory testing across hematology, chemistry and microbiology sections, ensuring accurate and timely results.</p>',
                'requirements' => ['ASCP or equivalent certification', "Bachelor's degree in medical technology or related field", 'Hospital lab experience preferred'],
                'benefits' => ['Shift differential', 'Weekly pay', 'Supportive lab leadership team'],
                'status' => 'open',
                'featured' => false,
            ],
            [
                'title' => 'Interim Nurse Manager — Emergency Department',
                'category' => 'Nursing Leadership',
                'location' => 'Columbus, OH',
                'job_type' => 'Interim leadership',
                'shift' => 'Days',
                'pay' => 'Competitive, based on experience',
                'summary' => 'Experienced nurse leader needed to steady a busy ED through a leadership transition.',
                'description' => '<p>Provide interim leadership for a high-volume emergency department, supporting staff, throughput and quality initiatives during a management transition.</p>',
                'requirements' => ['Active RN license', '3+ years ED leadership experience', 'BSN required, MSN preferred'],
                'benefits' => ['Premium pay', 'Travel support', 'Executive-level recruiter support'],
                'status' => 'open',
                'featured' => true,
            ],
            [
                'title' => 'Health Information Management Specialist',
                'category' => 'Healthcare IT',
                'location' => 'Remote (USA)',
                'job_type' => 'Full-time',
                'shift' => 'Business hours',
                'pay' => '$28–$34/hr',
                'summary' => 'Support medical records accuracy and compliance for a multi-site healthcare system.',
                'description' => '<p>Manage health information workflows including chart audits, release of information and EHR data integrity.</p>',
                'requirements' => ['RHIT or RHIA preferred', 'EHR system experience (Epic/Cerner)', 'Knowledge of HIPAA regulations'],
                'benefits' => ['Remote flexibility', 'Full benefits package', 'Growth opportunities'],
                'status' => 'open',
                'featured' => false,
            ],
            [
                'title' => 'Front Desk Associate — Clinic',
                'category' => 'Clerical & Administrative',
                'location' => 'Louisville, KY',
                'job_type' => 'Part-time',
                'shift' => 'Days',
                'pay' => '$17–$20/hr',
                'summary' => 'Welcoming front desk associate for a busy outpatient clinic.',
                'description' => '<p>Greet patients, manage scheduling, verify insurance and support day-to-day front office operations.</p>',
                'requirements' => ['Customer service experience', 'Familiarity with EHR scheduling systems a plus', 'Strong communication skills'],
                'benefits' => ['Flexible part-time schedule', 'On-the-job training', 'Friendly clinic environment'],
                'status' => 'closed',
                'featured' => false,
            ],
        ];

        foreach ($jobs as $job) {
            JobPosting::query()->updateOrCreate(
                ['slug' => Str::slug($job['title'])],
                $job + ['slug' => Str::slug($job['title'])]
            );
        }
    }
}

