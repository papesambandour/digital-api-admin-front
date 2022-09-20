<?php


namespace App\Services\Helpers\Export\Pdf;

//https://github.com/dompdf/dompdf
//https://ourcodeworld.com/articles/read/226/top-5-best-open-source-pdf-generation-libraries-for-php
use App\Services\Helpers\Utils;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class PdfExportService implements PdfExportAbstractService
{
    public function exportGeneric(Request $request){
        $filename = $request->get('name',null);
        $title = $request->get('title','Liste');
        $data = $request->get('data',[]);
        $view = view('pdf.export',compact(['data','title']));
        $view = $view->render();
        return  $this->exportInternal($view,$filename,true);
    }
    public  function exportInternal($view,$filename=null, $base64=false){
        $options = new Options();
        $options->set('defaultFont', 'Open Sans');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        if($base64){
            $output = $dompdf->output();
            $b64Doc = base64_encode($output);
            return Utils::respond('done',"data:application/pdf;base64," .$b64Doc);
        }else{
            $dompdf->stream($filename ?: gmdate('Y-m-d').'.pdf');die;
        }
    }


}
