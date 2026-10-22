<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppIcon extends Component
{
    /** Map our seeded Lucide-style icon names to the closest Heroicon outline icon. */
    private const MAP = [
        'HeartPulse' => 'heart',
        'Layers' => 'rectangle-stack',
        'ShieldCheck' => 'shield-check',
        'Handshake' => 'hand-raised',
        'Compass' => 'globe-alt',
        'Users' => 'users',
        'Clock' => 'clock',
        'TrendingUp' => 'arrow-trending-up',
        'UserCheck' => 'user-plus',
        'BadgeCheck' => 'check-badge',
        'FlaskConical' => 'beaker',
        'Search' => 'magnifying-glass',
        'Rocket' => 'rocket-launch',
        'LifeBuoy' => 'chat-bubble-left-right',
        'Briefcase' => 'briefcase',
        'GraduationCap' => 'academic-cap',
        'FileCheck2' => 'document-check',
        'HeartHandshake' => 'heart',
        'Building2' => 'building-office-2',
        'Zap' => 'bolt',
        'Cpu' => 'cpu-chip',
        'Stethoscope' => 'heart',
        'Identification' => 'identification',
        'ChartPie' => 'chart-pie',
        'PencilSquare' => 'pencil-square',
        'Mail' => 'envelope',
        'Phone' => 'phone',
        'MapPin' => 'map-pin',
        'Calendar' => 'calendar',
        'Star' => 'star',
        'Check' => 'check-circle',
        'ArrowRight' => 'arrow-right',
    ];

    public string $heroicon;

    public function __construct(public ?string $name = null, public string $class = 'w-6 h-6')
    {
        $this->heroicon = 'heroicon-o-'.(self::MAP[$name] ?? 'sparkles');
    }

    public function render(): View
    {
        return view('components.app-icon');
    }
}
