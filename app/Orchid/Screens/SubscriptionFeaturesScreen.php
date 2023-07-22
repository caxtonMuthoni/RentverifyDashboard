<?php

namespace App\Orchid\Screens;

use App\Models\Subscription;
use App\Models\SubscriptionFeature;
use App\Orchid\Layouts\SubscriptionFeaturesListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class SubscriptionFeaturesScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Subscription $subscription): iterable
    {
        return [
            'features' => SubscriptionFeature::where('subscription_id', $subscription->id)->latest()->get()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Subscription Features';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Add new package feature')
                ->icon('plus')
                ->type(Color::PRIMARY())
                ->modal('packageFeatureModal')
                ->modalTitle('Add package feature ')
                ->method('addPackageFeature'),

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
            SubscriptionFeaturesListLayout::class,
            Layout::modal('packageFeatureModal', Layout::rows([
                TextArea::make('feature')
                    ->title('Package feature')
                    ->required()
                    ->help('Enter the feature you wish to add here')
            ]))
                ->applyButton('Save feature'),
        ];
    }

    public function addPackageFeature(Request $request, Subscription $subscription)
    {
        $feature = SubscriptionFeature::where([['feature', $request->feature], ['subscription_id', $subscription->id]])->first();
        if (!isset($feature)) {
            $feature = new SubscriptionFeature();
        }
        $feature->feature = $request->feature;
        $feature->subscription_id = $subscription->id;
        $feature->save();

        Alert::success('The features were updated sucessfully');
    }

    public function deleteFeature(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $feature = SubscriptionFeature::find($id);
            if (isset($feature)) {
                $feature->delete();
                Alert::success('The feature was deleted successfully!');
                return;
            }
        }

        Alert::error('The feature could not be deleted, please try again');
    }
}
