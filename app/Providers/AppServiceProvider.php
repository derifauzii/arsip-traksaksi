<?php

namespace App\Providers;

use App\Http\Responses\CustomLogoutResponse;
use App\Http\Responses\LogoutResponse as ResponsesLogoutResponse;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Css;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind(LogoutResponse::class, function () {
            return new class implements LogoutResponse {
                public function toResponse($request)
                {
                    return redirect('/'); // Redirect ke landing page
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Filament::serving(function () {
        //     FilamentAsset::register([
        //         Css::make('custom-stylesheet', __DIR__ . '/../../resources/css/custom-sidebar.css'),
        //     ]);
        // });
    }
}
