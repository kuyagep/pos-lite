<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $feature = null)
    {
        $user = $request->user();

        if (! $user || ! $user->subscriptions()->latest()->first()?->active) {
            abort(403, 'No active subscription');
        }

        $subscription = $user->subscriptions()->latest()->first();

        if ($subscription->expires_at->lt(Carbon::now())) {
            abort(403, 'Subscription expired');
        }

        // If a specific feature is required, check plan features
        if ($feature) {
            $planFeatures = $subscription->plan->features ?? [];
            if (! ($planFeatures[$feature] ?? false)) {
                abort(403, 'Feature not available in your plan');
            }
        }

        return $next($request);
    }
}
