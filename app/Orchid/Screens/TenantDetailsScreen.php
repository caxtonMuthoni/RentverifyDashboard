<?php

namespace App\Orchid\Screens;

use App\Models\Defaulter;
use App\Models\Tenant;
use App\Models\TenantRoom;
use App\Orchid\Layouts\SingleTenantDefaultedPaymentsListLayout;
use App\Orchid\Layouts\SingleTenantRoomsListLayout;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;

class TenantDetailsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Tenant $tenant): iterable
    {
        return [
            'tenant' => $tenant->load(['idfrontimages', 'idbackimages']),
            'rooms' => TenantRoom::with('room.apartment', 'landlord')->where([['tenant_id', $tenant->id], ['is_active', true]])->latest()->take(10)->get(),
            'defaults' => Defaulter::with('landlord', 'room', 'apartment')->where('tenant_id', $tenant->id)->get(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Tenant Details';
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
            Layout::columns([
                Layout::legend('tenant', [
                    Sight::make('national_id', 'National ID'),
                    Sight::make('first_name', 'First Name'),
                    Sight::make('sir_name', 'Sir name'),
                    Sight::make('phone_number', 'Tenant phonenumber'),
                    Sight::make('email', 'Tenant email'),
                ]),

                Layout::legend('tenant', [
                    Sight::make('next_of_kin', 'Next of Kin'),
                    Sight::make('next_of_kin_phone_number', 'Next of Kin Phonenumber'),
                    Sight::make('next_of_kin_location', 'Next of Kin Location'),
                    Sight::make('next_of_kin_relationship', 'Next of Kin Relationship'),
                    Sight::make('next_of_kin_birth_day', 'Next of Kin Date of Birth'),
                ]),
            ]),

            Layout::columns([
                Layout::view('orchid.front-id-image'),
                Layout::view('orchid.back-id-image'),
            ]),

            SingleTenantRoomsListLayout::class,
            SingleTenantDefaultedPaymentsListLayout::class
        ];
    }
}
