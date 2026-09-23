<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Models\Reservation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    DB::listen(function ($query) {
    logger()->info('SQL QUERY', [
        'sql' => $query->sql,
        'time' => $query->time,
        'url' => request()->fullUrl(),
        'route' => request()->route()?->getName(),
    ]);
});

    View::composer('components.petugas.sidebar', function ($view) {
        $reservasiBaruCount = Reservation::where('status', 'menunggu')->count();

        $view->with('reservasiBaruCount', $reservasiBaruCount);
    });
}
}
