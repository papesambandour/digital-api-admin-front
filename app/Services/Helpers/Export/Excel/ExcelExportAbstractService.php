<?php


namespace App\Services\Helpers\Export\Excel;

use Illuminate\Http\Request;

interface ExcelExportAbstractService
{
    //https://phpspreadsheet.readthedocs.io/en/latest/
    public  function export(Request $request);
    public  function exportInternal(array $data );

}
