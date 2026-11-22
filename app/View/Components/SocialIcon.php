<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class SocialIcon extends Component
{
    /** Known platforms => [display label, badge background color, monogram shown in the icon]. */
    public const PLATFORMS = [
        'linkedin' => ['LinkedIn', '#0A66C2', 'in'],
        'facebook' => ['Facebook', '#1877F2', 'f'],
        'twitter' => ['X (Twitter)', '#000000', 'X'],
        'instagram' => ['Instagram', '#C13584', 'IG'],
        'youtube' => ['YouTube', '#FF0000', '▶'],
        'tiktok' => ['TikTok', '#000000', '♪'],
        'glassdoor' => ['Glassdoor', '#0CAA41', 'G'],
        'indeed' => ['Indeed', '#003A9B', 'Id'],
        'website' => ['Website', '#334155', '🌐'],
        'other' => ['Other', '#334155', '🔗'],
    ];

    public string $label;

    public string $color;

    public string $monogram;

    public function __construct(public string $platform, public ?string $customLabel = null, public string $class = 'h-9 w-9 text-xs')
    {
        [$label, $color, $monogram] = self::PLATFORMS[$platform] ?? ['Link', '#334155', '🔗'];

        $this->label = $customLabel ?: $label;
        $this->color = $color;
        $this->monogram = $monogram;
    }

    public function render(): View
    {
        return view('components.social-icon');
    }
}
