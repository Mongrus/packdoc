<?php

namespace App\Http\Controllers;

use App\Enums\DocumentPackageStatus;
use App\Models\DocumentCategory;
use App\Models\DocumentPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class DocumentPackageController extends Controller
{
    public function index(Request $request): Response
    {
        $packages = $request->user()
            ->documentPackages()
            ->with('category')
            ->latest()
            ->paginate(20);

        return Inertia::render('Packages', [
            'packages' => $packages,
            'status'   => session('status'),
        ]);
    }

    public function create(): Response
    {
        $categories = DocumentCategory::with('documentTemplates')->orderBy('name')->get();

        return Inertia::render('Packages/Create', [
            'categories' => $categories,
        ]);
    }

    public function questionnaire(DocumentCategory $category): Response
    {
        return Inertia::render('Packages/Questionnaire', [
            'category' => $category->load('documentTemplates'),
        ]);
    }

    public function duplicate(Request $request, DocumentPackage $package): RedirectResponse
    {
        abort_if($package->user_id !== $request->user()->id, 403);

        DocumentPackage::create([
            'user_id'     => $request->user()->id,
            'name'        => $package->name . ' (копия)',
            'category_id' => $package->category_id,
            'status'      => DocumentPackageStatus::Draft->value,
            'data'        => $package->data,
            'file_path'   => null,
        ]);

        return Redirect::route('packages.index')
            ->with('status', 'package-duplicated');
    }

    public function destroy(Request $request, DocumentPackage $package): RedirectResponse
    {
        abort_if($package->user_id !== $request->user()->id, 403);

        $package->delete();

        return Redirect::route('packages.index')
            ->with('status', 'package-deleted');
    }
}
