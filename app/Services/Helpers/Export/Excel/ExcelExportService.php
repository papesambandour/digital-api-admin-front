<?php


namespace App\Services\Helpers\Export\Excel;
use App\Services\Helpers\Utils;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;
class ExcelExportService implements ExcelExportAbstractService
{
    public  function export(Request $request){
        try {
            $data = $request->get('data');
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            /*SET CONTENT*/
            $y=1;
            $alfa = range('A','Z');
            foreach ($data as $value){
                $x = 0 ;
                foreach ($value as $key =>$va){
                    $sheet->setCellValue(@$alfa[$x++] . $y, ucfirst($key));
                }
                $y++ ;
                break;
            }
            foreach ($data as $value){
                $x = 0 ;
                foreach ($value as $key =>$va){
                    $sheet->setCellValue(@$alfa[$x++] . $y,$va);
                }
                $y++ ;
              //  break;
            }
          //  $sheet->setCellValue('A1', 'Hello World !');
            /*SET CONTENT*/
            $path = tempnam(sys_get_temp_dir(), '_sentinel_');
            $writer = new Xlsx($spreadsheet);
            $writer->save($path);
            $res = file_get_contents($path);
            $b64Doc = base64_encode(($res ?: ''));// file
            unlink($path);
           return Utils::respond('done',"data:application/xlsx;base64," . $b64Doc);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public  function exportInternal(array $data ){
        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            /*SET CONTENT*/
            $y=1;
            $alfa = range('A','Z');
            foreach ($data as $value){
                $x = 0 ;
                foreach ($value as $key =>$va){
                    $sheet->setCellValue(@$alfa[$x] . $y, ucfirst($key));
                    $sheet->getColumnDimension(@$alfa[$x])->setAutoSize(true);
                    $x++;
                }

                $y++ ;
                break;
            }
            foreach ($data as $value){
                $x = 0 ;
                foreach ($value as $key =>$va){
                    $sheet->setCellValue(@$alfa[$x] . $y,$va);
                    $sheet->getColumnDimension(@$alfa[$x])->setAutoSize(true);
                    $x++;
                }
                $y++ ;
            }
            $sheet->getStyle('A:Z')->getAlignment()->setHorizontal('left');

            //  $sheet->setCellValue('A1', 'Hello World !');
            /*SET CONTENT*/
            $path = tempnam(sys_get_temp_dir(), '_intech_api_');
            $writer = new Xlsx($spreadsheet);
            $writer->save($path);
            $res = file_get_contents($path);
            $b64Doc = base64_encode(($res ?: ''));// file
            unlink($path);
           return Utils::respond('done',"data:application/xlsx;base64," . $b64Doc);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}
