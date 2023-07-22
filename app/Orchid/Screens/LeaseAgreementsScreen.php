<?php

namespace App\Orchid\Screens;

use App\Models\LeaseAgreement;
use App\Orchid\Layouts\LeaseAgreementListLayout;
use Orchid\Screen\Screen;

class LeaseAgreementsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'leaseAgreements' => LeaseAgreement::with('apartment', 'room')->latest()->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Lease Agreements';
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
            LeaseAgreementListLayout::class
        ];
    }
}
