<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use App\Models\ContentText;

class PageController extends Controller
{
    public function about()
    {
        $t = fn (string $key, string $default = '') => ContentText::text('about', $key, $default);

        return view('pages.about', [
            't' => $t,
            'values' => ContentItem::group('about_values'),
            'principles' => ContentItem::group('principles'),
            'facts' => ContentItem::group('about_facts'),
            'locations' => ContentItem::group('about_locations'),
        ]);
    }

    public function services()
    {
        $t = fn (string $key, string $default = '') => ContentText::text('services', $key, $default);

        return view('pages.services', [
            't' => $t,
            'industries' => ContentItem::group('industries'),
            'specialtyGroups' => ContentItem::group('specialty_groups'),
        ]);
    }

    public function servicesHealthcare()
    {
        $t = fn (string $key, string $default = '') => ContentText::text('services_healthcare', $key, $default);

        return view('pages.services-detail', [
            't' => $t,
            'roles' => ContentItem::group('services_healthcare_roles'),
            'specialtyGroups' => ContentItem::group('services_healthcare_specialties'),
        ]);
    }

    public function servicesIt()
    {
        $t = fn (string $key, string $default = '') => ContentText::text('services_it', $key, $default);

        return view('pages.services-detail', [
            't' => $t,
            'roles' => ContentItem::group('services_it_roles'),
            'specialtyGroups' => ContentItem::group('services_it_specialties'),
        ]);
    }

    public function privacy()
    {
        $t = fn (string $key, string $default = '') => ContentText::text('privacy', $key, $default);

        return view('pages.privacy', ['t' => $t]);
    }
}

