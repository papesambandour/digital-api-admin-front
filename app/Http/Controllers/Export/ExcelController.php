<?php

namespace App\Http\Controllers\Export;
use App\Services\Helpers\Export\Excel\ExcelExportAbstractService;
use Illuminate\Http\Request;
class ExcelController
{
    private ExcelExportAbstractService $excelExportService;

    /**
     * @param ExcelExportAbstractService $excelExport
     */
    public function __construct(ExcelExportAbstractService $excelExport)
    {
        $this->excelExportService = $excelExport;
    }

    public function exportGeneric(Request $request){
     return $this->excelExportService->export($request);
  }
}
