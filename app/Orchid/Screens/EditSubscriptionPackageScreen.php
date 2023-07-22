<?php

namespace App\Orchid\Screens;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class EditSubscriptionPackageScreen extends Screen
{
    private $exists = false;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Subscription $subscription): iterable
    {
        $this->exists = $subscription->exists;
        return [
            'subscription' => $subscription
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->exists ? 'Edit subscription package' : 'Create new subscription package';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Save')
                ->type(Color::SUCCESS())
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Update')
                ->icon('note')
                ->type(Color::PRIMARY())
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Delete')
                ->type(Color::DANGER())
                ->confirm('You want to delete this package')
                ->icon('pencil')
                ->method('remove')
                ->canSee($this->exists),
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
            Layout::rows([
                Input::make('subscription.name')
                    ->title('Package name')
                    ->placeholder('eg. Gold')
                    ->help('Enter a unique package name')
                    ->required(),

                Input::make('subscription.price')
                    ->title('Package pricing')
                    ->placeholder('eg. 7000')
                    ->help('Enter a package price in KSH')
                    ->required(),

                TextArea::make('subscription.description')
                    ->title('Short package description')
                    ->placeholder('eg. Good for startups')
                    ->required()
                    ->help('Provide a short package description.')
            ])
        ];
    }

    public function createOrUpdate(Request $request, Subscription $subscription)
    {
        // validation
        $this->validate($request, [
            'subscription.name' => 'required | unique:subscriptions,name,' . $subscription?->id
        ], [
            'subscription.name.unique' => 'The package name must be unique.'
        ]);

        $requestData = $request->get('subscription');

        $subscription->name = $requestData['name'];
        $subscription->price = $requestData['price'];
        $subscription->description = $requestData['description'];
        $subscription->save();

        Alert::success('The subscription data was updated successfully, You can add the subscription features');
        return redirect()->route('platform.package-features', $subscription);
    }
}
