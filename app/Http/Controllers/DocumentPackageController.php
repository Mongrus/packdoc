<?php

namespace App\Http\Controllers;

use App\Enums\DocumentPackageStatus;
use App\Models\DocumentCategory;
use App\Models\DocumentPackage;
use App\Services\DocumentGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
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
        $validated = $this->validatePackageData($request);

        $package = DocumentPackage::create([
            'user_id' => $request->user()->id,
            'type'    => $validated['type'],
            'status'  => DocumentPackageStatus::Completed->value,
            'data'    => $validated['data'],
        ]);

        return Redirect::route('packages.documents', $package)
            ->with('status', 'package-created');
    }

    public function previewAll(Request $request, DocumentGeneratorService $generator): HttpResponse
    {
        $data = $this->validateDraftData($request);

        return $generator->streamCombinedPdf(
            $data['type'],
            self::FREELANCE_DOCUMENTS,
            $data['data'],
        );
    }

    public function storeDraft(Request $request): RedirectResponse
    {
        $data = $this->validateDraftData($request);

        DocumentPackage::create([
            'user_id' => $request->user()->id,
            'type'    => $data['type'],
            'status'  => DocumentPackageStatus::Draft->value,
            'data'    => $data['data'],
        ]);

        return Redirect::route('packages.index')
            ->with('status', 'draft-saved');
    }

    private const TYPE_CATEGORY_MAP = [
        'freelance' => 'Фриланс',
    ];

    public function edit(Request $request, DocumentPackage $package): Response
    {
        abort_if($package->user_id !== $request->user()->id, 403);

        $categoryName = self::TYPE_CATEGORY_MAP[$package->type] ?? null;
        abort_unless($categoryName, 404);

        $category = DocumentCategory::with('documentTemplates')
            ->where('name', $categoryName)
            ->firstOrFail();

        return Inertia::render('Packages/Questionnaire', [
            'category' => $category,
            'profile'  => $request->user()->profile,
            'package'  => $package,
        ]);
    }

    public function update(Request $request, DocumentPackage $package): RedirectResponse
    {
        abort_if($package->user_id !== $request->user()->id, 403);

        $validated = $this->validatePackageData($request);

        $package->update([
            'status' => DocumentPackageStatus::Completed->value,
            'data'   => $validated['data'],
        ]);

        return Redirect::route('packages.documents', $package)
            ->with('status', 'package-updated');
    }

    public function saveDraft(Request $request, DocumentPackage $package): RedirectResponse
    {
        abort_if($package->user_id !== $request->user()->id, 403);

        $data = $this->validateDraftData($request);

        $package->update([
            'status' => DocumentPackageStatus::Draft->value,
            'data'   => $data['data'],
        ]);

        return Redirect::route('packages.index')
            ->with('status', 'draft-saved');
    }

    public function documents(Request $request, DocumentPackage $package): Response
    {
        abort_if($package->user_id !== $request->user()->id, 403);

        $docs = collect(self::FREELANCE_DOCUMENTS)->map(fn ($title, $slug) => [
            'slug'   => $slug,
            'title'  => $title,
            'url'    => route('packages.document.render', [$package, $slug]),
            'pdfUrl'     => route('packages.document.pdf', [$package, $slug]),
            'previewUrl' => route('packages.document.preview', [$package, $slug]),
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

    public function downloadPdf(
        Request $request,
        DocumentPackage $package,
        string $document,
        DocumentGeneratorService $generator,
    ): HttpResponse {
        abort_if($package->user_id !== $request->user()->id, 403);
        abort_unless(array_key_exists($document, self::FREELANCE_DOCUMENTS), 404);

        $template = "documents.{$package->type}.{$document}";
        $filename = "{$document}-{$package->id}";

        return $generator->downloadPdf($template, $package->data, $filename);
    }

    public function previewPdf(
        Request $request,
        DocumentPackage $package,
        string $document,
        DocumentGeneratorService $generator,
    ): HttpResponse {
        abort_if($package->user_id !== $request->user()->id, 403);
        abort_unless(array_key_exists($document, self::FREELANCE_DOCUMENTS), 404);

        $template = "documents.{$package->type}.{$document}";
        $filename = "{$document}-{$package->id}";

        return $generator->streamPdf($template, $package->data, $filename);
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

    private function validatePackageData(Request $request): array
    {
        return $request->validate([
            'type'                       => 'required|string|in:freelance',
            'data.contract.number'       => 'required|string|max:50',
            'data.contract.date'         => 'required|date',
            'data.contract.city'         => 'nullable|string|max:100',
            'data.contractor.name'       => 'required|string|max:255',
            'data.contractor.email'      => 'required|email|max:255',
            'data.contractor.phone'      => 'nullable|string|max:50',
            'data.client.name'           => 'required|string|max:255',
            'data.client.email'          => 'required|email|max:255',
            'data.service.name'          => 'required|string|max:255',
            'data.service.description'   => 'nullable|string|max:2000',
            'data.service.start_date'    => 'nullable|date',
            'data.service.end_date'      => 'nullable|date',
            'data.payment.price'         => 'required|string|max:100',
            'data.payment.currency'      => 'nullable|string|max:10',
            'data.payment.terms'         => 'nullable|string|max:255',
            'data.payment.details'       => 'nullable|string|max:500',
            'data.payment.due_date'      => 'nullable|date',
            'data.meta.act_number'       => 'nullable|string|max:50',
            'data.meta.invoice_number'   => 'nullable|string|max:50',
            'data.meta.acceptance_days'  => 'nullable|integer|min:1|max:30',
            'data.meta.penalty_terms'    => 'nullable|string|max:255',
        ], [
            'data.contract.number.required'  => 'Укажите номер договора.',
            'data.contract.date.required'    => 'Укажите дату договора.',
            'data.contractor.name.required'  => 'Укажите ФИО исполнителя.',
            'data.contractor.email.required' => 'Укажите email исполнителя.',
            'data.contractor.email.email'    => 'Введите корректный email исполнителя.',
            'data.client.name.required'      => 'Укажите ФИО или название компании заказчика.',
            'data.client.email.required'     => 'Укажите email заказчика.',
            'data.client.email.email'        => 'Введите корректный email заказчика.',
            'data.service.name.required'     => 'Укажите название услуги.',
            'data.payment.price.required'    => 'Укажите стоимость.',
        ]);
    }

    private function validateDraftData(Request $request): array
    {
        return $request->validate([
            'type'                       => 'required|string|in:freelance',
            'data'                       => 'required|array',
            'data.contract.number'       => 'nullable|string|max:50',
            'data.contract.date'         => 'nullable|date',
            'data.contract.city'         => 'nullable|string|max:100',
            'data.contractor.name'       => 'nullable|string|max:255',
            'data.contractor.email'      => 'nullable|email|max:255',
            'data.contractor.phone'      => 'nullable|string|max:50',
            'data.client.name'           => 'nullable|string|max:255',
            'data.client.email'          => 'nullable|email|max:255',
            'data.service.name'          => 'nullable|string|max:255',
            'data.service.description'   => 'nullable|string|max:2000',
            'data.service.start_date'    => 'nullable|date',
            'data.service.end_date'      => 'nullable|date',
            'data.payment.price'         => 'nullable|string|max:100',
            'data.payment.currency'      => 'nullable|string|max:10',
            'data.payment.terms'         => 'nullable|string|max:255',
            'data.payment.details'       => 'nullable|string|max:500',
            'data.payment.due_date'      => 'nullable|date',
            'data.meta.act_number'       => 'nullable|string|max:50',
            'data.meta.invoice_number'   => 'nullable|string|max:50',
            'data.meta.acceptance_days'  => 'nullable|integer|min:1|max:30',
            'data.meta.penalty_terms'    => 'nullable|string|max:255',
        ]);
    }
}
