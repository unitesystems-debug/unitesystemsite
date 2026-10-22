<?php

namespace App\Filament\Resources\ContentItems\Pages;

use App\Filament\Resources\ContentItems\ContentItemResource;
use App\Filament\Resources\ContentItems\Schemas\ContentItemForm;
use App\Models\ContentItem;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListContentItems extends ListRecords
{
    protected static string $resource = ContentItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    /**
     * One tab per site page (see ContentItemForm::PAGE_GROUPS), so admins
     * can jump straight to "Home page" / "About page" / etc. instead of
     * scrolling or hunting through a dropdown of raw group names.
     */
    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('All')
                ->badge(ContentItem::count()),
        ];

        foreach (ContentItemForm::PAGE_GROUPS as $label => $groups) {
            $tabs[$label] = Tab::make($label)
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('group', $groups))
                ->badge(ContentItem::whereIn('group', $groups)->count());
        }

        return $tabs;
    }
}
