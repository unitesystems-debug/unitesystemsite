<?php

namespace App\Filament\Widgets;

use App\Models\CandidateProfile;
use App\Models\ContactMessage;
use App\Models\JobApplication;
use App\Models\JobPosting;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Open jobs', JobPosting::where('status', 'open')->count())
                ->description('Currently published')
                ->color('success'),
            Stat::make('New applications', JobApplication::where('status', 'new')->count())
                ->description('Awaiting review')
                ->color('warning'),
            Stat::make('Total applications', JobApplication::count())
                ->description('All time'),
            Stat::make('Registered candidates', CandidateProfile::count()),
            Stat::make('Unread enquiries', ContactMessage::where('is_read', false)->count())
                ->color('danger'),
        ];
    }
}

