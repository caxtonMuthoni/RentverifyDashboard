<?php

namespace App\Orchid\Screens;

use App\Models\Subscription;
use App\Orchid\Layouts\SubscriptionPackagesListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class SubscriptionPackagesScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'packages' => Subscription::withCount('features')->latest()->get()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Subscription Packages';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Create new')
                ->icon('plus')
                ->route('platform.package-edit')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            SubscriptionPackagesListLayout::class
        ];
    }
}
