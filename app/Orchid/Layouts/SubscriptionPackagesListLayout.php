<?php

namespace App\Orchid\Layouts;

use App\Models\Subscription;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class SubscriptionPackagesListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'packages';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', "Package Name"),
            TD::make('description', "Package Description"),
            TD::make('price', "Package price"),
            TD::make('features_count', 'Total features'),
            TD::make('features', 'Features')->render(fn (Subscription $subscription) => Link::make('Features')
                ->icon('list')
                ->type(Color::INFO())
                ->route('platform.package-features', $subscription)),
            TD::make('edit', 'Edit')->render(fn (Subscription $subscription) => Link::make('Edit')
                ->icon('pencil')
                ->type(Color::PRIMARY())
                ->route('platform.package-edit', $subscription)),
        ];
    }
}
