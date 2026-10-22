<?php

namespace App\Providers;

use App\Models\ContentItem;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.app', 'pages.*', 'jobs.*', 'auth.*', 'partials.*'], function ($view) {
            $view->with([
                'siteNav' => ContentItem::group('nav_main'),
                'siteFooterColumns' => ContentItem::group('footer_columns'),
                'siteCompany' => [
                    'name' => Setting::get('company_name', 'Unite Systems'),
                    'legal' => Setting::get('company_legal', 'Unite Systems LLC'),
                    'phone' => Setting::get('company_phone', '855-792-1297'),
                    'phone_href' => Setting::get('company_phone_href', 'tel:+18557921297'),
                    'email' => Setting::get('company_email', 'info@unitesystemsllc.com'),
                    'hq' => Setting::get('company_hq', 'Kentucky, USA'),
                    'presence' => Setting::get('company_presence', 'USA and India'),
                    'tagline' => Setting::get('company_tagline', ''),
                    'logo' => Setting::get('logo'),
                    'favicon' => Setting::get('favicon'),
                    'social_facebook' => Setting::get('social_facebook'),
                    'social_linkedin' => Setting::get('social_linkedin'),
                    'social_twitter' => Setting::get('social_twitter'),
                    'social_instagram' => Setting::get('social_instagram'),
                ],
                'siteFooterNote' => \App\Models\ContentText::text('global', 'footer_note', 'Equal Opportunity Employer.'),
                'siteNavCtaLabel' => \App\Models\ContentText::text('global', 'nav_cta_label', 'Let’s Connect'),
                'siteNavCtaHref' => \App\Models\ContentText::text('global', 'nav_cta_href', '/contact'),
                'siteChatEnabled' => Setting::get('chat_enabled', '1') === '1',
                'siteChatWelcome' => Setting::get('chat_welcome', ''),
            ]);
        });
    }
}
