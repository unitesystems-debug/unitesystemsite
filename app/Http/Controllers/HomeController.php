<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use App\Models\ContentText;
use App\Models\JobPosting;

class HomeController extends Controller
{
    public function index()
    {
        $text = fn (string $key, string $default = '') => ContentText::text('home', $key, $default);

        return view('pages.home', [
            't' => $text,
            'heroImage' => ContentText::image('home', 'hero_image'),
            'trust' => ContentItem::group('home_trust'),
            'challenges' => ContentItem::group('home_challenges'),
            'solutions' => ContentItem::group('home_solutions'),
            'process' => ContentItem::group('home_process'),
            'humantechProfessionals' => ContentItem::group('home_humantech_professionals'),
            'humantechOrganizations' => ContentItem::group('home_humantech_organizations'),
            'humantechHubLayers' => ContentItem::group('home_humantech_hub_layers'),
            'professionalBenefits' => ContentItem::group('professional_benefits'),
            'specialties' => ContentItem::group('specialties'),
            'employerPoints' => ContentItem::group('employer_points'),
            'employerSectors' => ContentItem::group('employer_sectors'),
            'testimonials' => ContentItem::group('testimonials'),
            'insights' => ContentItem::group('insights'),
            'featuredJobs' => JobPosting::open()->orderByDesc('featured')->latest()->take(3)->get(),
        ]);
    }
}

