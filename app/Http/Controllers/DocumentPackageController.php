<?php

namespace App\Http\Controllers;

use App\Enums\DocumentPackageStatus;
use App\Models\DocumentCategory;
use App\Models\DocumentPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

class DocumentPackageController extends Controller
{
    private const FREELANCE_DOCUMENTS = [
        'contract' => 'Договор на фриланс-услуги',
        'act'      => 'Акт выполненных работ',
        'invoice'  => 'Инвойс',
    ];

    public function index(Request $request): Response
    {
        $packages = $request->user()
            ->documentPackages()
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

    public function questionnaire(Request $request, DocumentCategory $category): Response
    {
        return Inertia::render('Packages/Questionnaire', [
            'category' => $category->load('documentTemplates'),
            'profile'  => $request->user()->profile,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type'                     => 'required|string|in:freelance',
            'data.contractor_name'     => 'required|string|max:255',
            'data.contractor_email'    => 'required|email|max:255',
            'data.contractor_phone'    => 'nullable|string|max:50',
            'data.client_name'         => 'required|string|max:255',
            'data.client_email'        => 'required|email|max:255',
            'data.service'             => 'required|string|max:255',
            'data.service_description' => 'nullable|string|max:2000',
            'data.price'               => 'required|string|max:100',
            'data.date'                => 'required|date',
        ], [
            'data.contractor_name.required' => 'Укажите ФИО исполнителя.',
            'data.contractor_email.required' => 'Укажите email исполнителя.',
            'data.contractor_email.email'    => 'Введите корректный email исполнителя.',
            'data.client_name.required'      => 'Укажите ФИО или название компании заказчика.',
            'data.client_email.required'     => 'Укажите email заказчика.',
            'data.client_email.email'        => 'Введите корректный email заказчика.',
            'data.service.required'          => 'Укажите название услуги.',
            'data.price.required'            => 'Укажите стоимость.',
            'data.date.required'             => 'Укажите дату.',
            'data.date.date'                 => 'Введите корректную дату.',
        ]);

        $package = DocumentPackage::create([
            'user_id' => $request->user()->id,
            'type'    => $validated['type'],
            'status'  => DocumentPackageStatus::Completed->value,
            'data'    => $validated['data'],
        ]);

        return Redirect::route('packages.documents', $package)
            ->with('status', 'package-created');
    }

    public function documents(Request $request, DocumentPackage $package): Response
    {
        abort_if($package->user_id !== $request->user()->id, 403);

        $docs = collect(self::FREELANCE_DOCUMENTS)->map(fn ($title, $slug) => [
            'slug'  => $slug,
            'title' => $title,
            'url'   => route('packages.document.render', [$package, $slug]),
        ])->values();

        return Inertia::render('Packages/Documents', [
            'package'   => $package,
            'documents' => $docs,
        ]);
    }

    public function renderDocument(Request $request, DocumentPackage $package, string $document): View
    {
        abort_if($package->user_id !== $request->user()->id, 403);
        abort_unless(array_key_exists($document, self::FREELANCE_DOCUMENTS), 404);

        return view("documents.{$package->type}.{$document}", [
            'data' => $package->data,
        ]);
    }

    public function duplicate(Request $request, DocumentPackage $package): RedirectResponse
    {
        abort_if($package->user_id !== $request->user()->id, 403);

        DocumentPackage::create([
            'user_id' => $request->user()->id,
            'type'    => $package->type,
            'status'  => DocumentPackageStatus::Draft->value,
            'data'    => $package->data,
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
