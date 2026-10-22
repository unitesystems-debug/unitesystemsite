<?php

namespace App\Filament\Resources\ContentTexts\Pages;

use App\Filament\Resources\ContentTexts\ContentTextResource;
use App\Filament\Resources\ContentTexts\Schemas\ContentTextForm;
use App\Models\ContentText;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListContentTexts extends ListRecords
{
    protected static string $resource = ContentTextResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    /**
     * One tab per page (the `page` column already matches site pages 1:1),
     * so admins can jump straight to "Home page" / "About page" / etc.
     */
    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('All')
                ->badge(ContentText::count()),
        ];

        foreach (ContentTextForm::PAGES as $key => $label) {
            $tabs[$key] = Tab::make($label)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('page', $key))
                ->badge(ContentText::where('page', $key)->count());
        }

        return $tabs;
    }
}
