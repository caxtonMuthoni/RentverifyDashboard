<?php

namespace App\Orchid\Screens;

use App\Imports\PlaceImport;
use App\Models\Place;
use App\Orchid\Layouts\PlacesListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Maatwebsite\Excel\Facades\Excel;

class PlacesScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'places' => Place::with('county')->latest()->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Places';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Upload places')
                ->modal('importLocationsModal')
                ->method('importLocations')
                ->icon('cloud-upload'),
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
            PlacesListLayout::class,
            Layout::modal(
                'importLocationsModal',
                Layout::rows([
                    Input::make('file')->type('file')
                        ->title('Upload places data')
                        ->required()
                        ->help('Upload .csv, .xslx files only.')
                ])
            )->title('Import places'),
        ];
    }

    public function importLocations(Request $request)
    {
        try {
            $file = $request->file('file');
            Excel::import(new PlaceImport, $file);
            Alert::success("The places data was uploaded successfully.");
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
        }
    }
}
