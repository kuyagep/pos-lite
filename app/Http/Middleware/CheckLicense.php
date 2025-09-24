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
        $licenseKey = config('app.license_key');

        $license = License::where('license_key', $licenseKey)->first();

        if (!$license || !$license->isValid()) {
            return redirect()->route('license.activate')
                ->with('error', 'Your software license is invalid or expired.');
        }

        return $next($request);
    }
}
