<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
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
  // AppServiceProvider ya jis file mein aapka boot() hai
public function boot(): void
{
    Paginator::useBootstrapFive();
    View::composer('*', function ($view) {
        $today = Carbon::today();
        $upcoming_alerts_count = Order::whereNotNull('alert_before_days')
            ->whereIn('order_status', ['pending', 'working']) // ✅ Only active statuses
            ->whereDate('delivery_date', '>=', $today)
            ->get()
            ->filter(function ($order) use ($today) {
                $alertDate = Carbon::parse($order->delivery_date)->subDays($order->alert_before_days);
                return $today->greaterThanOrEqualTo($alertDate);
            })
            ->count();

        $view->with('upcoming_alerts_count', $upcoming_alerts_count);
    });
}
}

