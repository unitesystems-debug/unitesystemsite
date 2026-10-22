<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::set('notify_email', 'admin@unitesystemsllc.com');
        Setting::set('candidate_confirmation', '1');
        Setting::set('chat_enabled', '1');
        Setting::set('chat_welcome', 'Hi! Ask me about our open jobs or services and I\'ll do my best to help.');
        Setting::set('footer_legal_text', 'Equal Opportunity Employer.');
    }
}
