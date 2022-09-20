<?php

namespace App\Http\Controllers\Export;
use App\Services\Helpers\Export\Pdf\PdfExportAbstractService;
use Illuminate\Http\Request;
class PdfController
{
    private PdfExportAbstractService $pdfExportService;

    /**
     * @param PdfExportAbstractService $pdfExportService
     */
    public function __construct(PdfExportAbstractService $pdfExportService)
    {
        $this->pdfExportService = $pdfExportService;
    }

    public function export(Request $request){
       return $this->pdfExportService->exportGeneric($request);
   }
}
