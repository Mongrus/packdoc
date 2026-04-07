<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $emptyProfileFields = 0;

        if ($user = $request->user()) {
            $profile = $user->profile;
            $tracked = ['full_name', 'phone', 'company_name', 'job_title', 'address', 'tax_id', 'employment_type', 'default_currency'];

            foreach ($tracked as $field) {
                if (empty($profile?->$field)) {
                    $emptyProfileFields++;
                }
            }
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'profileEmptyCount' => $emptyProfileFields,
        ];
    }
}
