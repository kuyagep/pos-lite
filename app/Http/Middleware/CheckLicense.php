<?php

namespace App\Http\Middleware;

use App\Models\License;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLicense
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // allow activation routes without license
        if ($request->routeIs('license.*') || $request->is('license/*')) {
            return $next($request);
        }

        $licenseKey = trim(config('app.license_key') ?? '');
        if (empty($licenseKey)) {
            return redirect()->route('license.activate')->with('error', 'Please activate license.');
        }

        $license = License::where('license_key', $licenseKey)->first();

        if (!$license || !$license->isValid()) {
            return redirect()->route('license.activate')
                ->with('error', 'Your software license is invalid or expired.');
        }

        return $next($request);
    }
}
