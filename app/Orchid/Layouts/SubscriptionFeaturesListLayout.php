<?php

namespace App\Orchid\Layouts;

use App\Models\SubscriptionFeature;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class SubscriptionFeaturesListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'features';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('feature', 'Feature'),
            TD::make('', 'Delete')->render(fn (SubscriptionFeature $subscriptionFeature) => Button::make('Deleted')
                ->icon('trash')
                ->type(Color::DANGER())
                ->method('deleteFeature', ['id' => $subscriptionFeature->id]))
        ];
    }
}
