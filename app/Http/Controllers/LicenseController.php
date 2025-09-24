<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function showActivateForm()
    {
        return view('license.activate');
    }

    public function activate(Request $request)
    {
        $request->validate([
            'license_key' => 'required|string',
        ]);

        $license = License::where('license_key', $request->license_key)->first();

        if (!$license || !$license->isValid()) {
            return back()->with('error', 'Invalid or expired license key.');
        }

        // Save license in .env file
        $this->setEnvValue('APP_LICENSE_KEY', $license->license_key);

        return redirect()->route('dashboard')->with('success', 'License activated successfully!');
    }

    private function setEnvValue($key, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, preg_replace(
                "/^{$key}=.*/m",
                "{$key}={$value}",
                file_get_contents($path)
            ));
        }
    }
}
