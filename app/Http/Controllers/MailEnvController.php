<?php

// app/Http/Controllers/MailEnvController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MailEnvController extends Controller
{
    // Show the mail settings form
    public function showForm()
    {
        return view('pages.dashboard.mail_setting');
    }

    // Update mail settings from the form and update the .env file
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'MAIL_HOST' => 'required|string',
            'MAIL_PORT' => 'required|integer',
            'MAIL_USERNAME' => 'nullable|string',
            'MAIL_PASSWORD' => 'nullable|string',
            'MAIL_ENCRYPTION' => 'nullable|string',
            'MAIL_FROM_ADDRESS' => 'required|email',
        ]);

        // Use Artisan to set the values in the .env file
        foreach ($validated as $key => $value) {
            Artisan::call('env:manage-mail', [
                'action' => 'set',
                'key' => $key,
                'value' => $value
            ]);
        }

        return redirect()->route('mail.settings')->with('success', 'Mail settings updated successfully.');
    }
}

