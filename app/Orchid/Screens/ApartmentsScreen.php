<?php

namespace App\Orchid\Screens;

use App\Models\Apartment;
use App\Orchid\Layouts\ApartmentsListLayout;
use Orchid\Screen\Screen;

class ApartmentsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'apartments' => Apartment::with('image', 'landlord')->withCount('rooms')->latest()->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'All Apartments';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ApartmentsListLayout::class
        ];
    }
}
