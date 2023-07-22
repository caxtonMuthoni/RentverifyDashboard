<?php

namespace App\Orchid\Screens;

use App\Models\Tenant;
use App\Models\TenantRoom;
use App\Orchid\Layouts\TenantsListLayout;
use Orchid\Screen\Screen;

class TenantsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'tenants' => TenantRoom::with('tenant', 'room')->latest()->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Tenants';
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
            TenantsListLayout::class
        ];
    }
}
