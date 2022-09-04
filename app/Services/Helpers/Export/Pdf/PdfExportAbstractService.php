<?php


namespace App\Services\Helpers\Export\Pdf;

//https://github.com/dompdf/dompdf
//https://ourcodeworld.com/articles/read/226/top-5-best-open-source-pdf-generation-libraries-for-php
use App\Services\Helpers\Utils;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

interface PdfExportAbstractService
{
    function exportInternal($view,$filename=null, $base64=false);
    function exportGeneric(Request $request);


}
