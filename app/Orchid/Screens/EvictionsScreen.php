<?php

namespace App\Orchid\Screens\Landlord;

use App\Models\Eviction;
use App\Orchid\Layouts\Landlord\EvictionsListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class EvictionsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'evictions' => Eviction::with('tenant', 'tenant_room.room.apartment')->landlordEvictions()->latest()->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Evictions';
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
                ->route('landlord-eviction-edit')
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
            EvictionsListLayout::class
        ];
    }
}
