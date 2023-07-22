<?php

namespace App\Orchid\Screens;

use App\Models\ClearlanceReport;
use App\Orchid\Layouts\ClearanceReportListLayout;
use Orchid\Screen\Screen;

class ClearanceReportsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'clearanceReports' => ClearlanceReport::with('tenant', 'room')->latest()->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Clearance Reports';
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
            ClearanceReportListLayout::class
        ];
    }
}
