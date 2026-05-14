<?php

namespace App\Http\Controllers;

use App\Enums\DocumentPackageStatus;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $user = $request->user();
        $profile = $user->profile;

        $trackedFields = ['full_name', 'phone', 'company_name', 'job_title', 'address', 'tax_id', 'employment_type', 'default_currency'];
        $filledCount = 0;

        foreach ($trackedFields as $field) {
            if (! empty($profile?->$field)) {
                $filledCount++;
            }
        }

        $totalPackages = $user->documentPackages()->count();
        $draftCount = $user->documentPackages()->where('status', DocumentPackageStatus::Draft)->count();
        $completedCount = $user->documentPackages()->where('status', DocumentPackageStatus::Completed)->count();

        return Inertia::render('Dashboard', [
            'stats' => [
                'total' => $totalPackages,
                'drafts' => $draftCount,
                'completed' => $completedCount,
            ],
            'progress' => [
                'profileFilled' => $filledCount,
                'profileTotal' => count($trackedFields),
                'hasPackages' => $totalPackages > 0,
            ],
        ]);
    }
}
