<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class DocumentGeneratorService
{
    public function downloadPdf(string $template, array $data, string $filename): Response
    {
        return $this->buildPdf($template, $data)->download("{$filename}.pdf");
    }

    public function streamPdf(string $template, array $data, string $filename): Response
    {
        return $this->buildPdf($template, $data)->stream("{$filename}.pdf");
    }

    public function streamCombinedPdf(string $type, array $templates, array $data): Response
    {
        $sections = [];
        foreach ($templates as $slug => $title) {
            $html = view("documents.{$type}.{$slug}", ['data' => $data])->render();
            $sections[] = preg_match('/<body[^>]*>(.*)<\/body>/s', $html, $m) ? $m[1] : $html;
        }

        $pdf = Pdf::loadView('documents.preview-all', ['sections' => $sections])
            ->setPaper('a4')
            ->setOption('defaultFont', 'DejaVu Sans');

        return $pdf->stream('preview.pdf');
    }

    private function buildPdf(string $template, array $data): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView($template, ['data' => $data])
            ->setPaper('a4')
            ->setOption('defaultFont', 'DejaVu Sans');
    }
}
