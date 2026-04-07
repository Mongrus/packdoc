<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class UserProfileController extends Controller
{
    public function edit(Request $request): Response
    {
        return Inertia::render('Account', [
            'userProfile' => $request->user()->profile,
            'status'      => session('status'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name'          => ['required', 'string', 'max:255'],
            'company_name'       => ['nullable', 'string', 'max:255'],
            'job_title'          => ['nullable', 'string', 'max:255'],
            'address'            => ['nullable', 'string', 'max:500'],
            'tax_id'             => ['nullable', 'string', 'max:50'],
            'phone'              => ['nullable', 'string', 'max:50'],
            'employment_type'    => ['required', Rule::in(['freelancer', 'employee', 'self-employed', 'company'])],
            'default_currency'   => ['required', 'string', 'max:10'],
        ]);

        $request->user()->profile()->updateOrCreate(
            ['user_id' => $request->user()->id],
            $validated,
        );

        return Redirect::route('account')
            ->with('status', 'profile-updated');
    }
}
