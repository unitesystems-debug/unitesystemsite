<?php

namespace Database\Seeders;

use App\Models\ContentItem;
use App\Models\ContentText;
use Illuminate\Database\Seeder;

/**
 * Adds the "Human expertise. Smarter workforce technology." hub-diagram section
 * to the home page. Kept as its own seeder (rather than folding into
 * ContentSeeder) so it can be re-run safely without touching any other
 * page content an admin may have already customized.
 */
class HumanTechSeeder extends Seeder
{
    public function run(): void
    {
        $text = function (string $key, string $label, string $value, string $type = 'text') {
            ContentText::query()->updateOrCreate(
                ['page' => 'home', 'key' => $key],
                ['label' => $label, 'value' => $value, 'type' => $type]
            );
        };

        $text('humantech_eyebrow', 'Human expertise — eyebrow', 'Our approach');
        $text('humantech_title', 'Human expertise — title', 'Human expertise. Smarter workforce technology.');
        $text('humantech_intro', 'Human expertise — intro', 'Recruiters who understand healthcare, supported by our own sourcing platform, connecting the right professionals with the organizations that need them.', 'textarea');
        $text('humantech_left_label', 'Human expertise — left column label', 'Healthcare professionals');
        $text('humantech_right_label', 'Human expertise — right column label', 'Healthcare organizations');
        $text('humantech_hub_label', 'Human expertise — hub eyebrow', 'Unite Systems');
        $text('humantech_hub_title', 'Human expertise — hub title', 'People + platform');

        $items = function (string $group, array $rows) {
            ContentItem::query()->where('group', $group)->delete();

            foreach ($rows as $i => $row) {
                ContentItem::query()->create($row + ['group' => $group, 'sort_order' => $i, 'active' => true]);
            }
        };

        $items('home_humantech_professionals', [
            ['icon' => 'HeartPulse', 'title' => 'Nurses'],
            ['icon' => 'FlaskConical', 'title' => 'Allied & imaging'],
            ['icon' => 'Identification', 'title' => 'Health IT & admin'],
        ]);

        $items('home_humantech_organizations', [
            ['icon' => 'Building2', 'title' => 'Hospitals'],
            ['icon' => 'HeartPulse', 'title' => 'Clinics'],
            ['icon' => 'Building2', 'title' => 'Care facilities'],
        ]);

        $items('home_humantech_hub_layers', [
            ['icon' => 'Users', 'title' => 'Experienced healthcare recruiters'],
            ['icon' => 'Cpu', 'title' => 'In-house sourcing platform'],
            ['icon' => 'ShieldCheck', 'title' => 'Dedicated account management'],
        ]);
    }
}
