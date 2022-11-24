<?php
use Google\CloudFunctions\FunctionsFramework;
use Psr\Http\Message\ServerRequestInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Excel;

// Register the function with Functions Framework.
// This enables omitting the `FUNCTIONS_SIGNATURE_TYPE=http` environment
// variable when deploying. The `FUNCTION_TARGET` environment variable should
// match the first parameter.
FunctionsFramework::http('helloHttp', 'helloHttp');

$a = new Excel();

function helloHttp(ServerRequestInterface $request): string
{
   $name = 'World';
   $body = $request->getBody()->getContents();
   //$prev = file_get_contents('./a.txt');
   //echo $prev."<br/>";
   if (!empty($body)) {
       $json = json_decode($body, true);
       if (json_last_error() != JSON_ERROR_NONE) {
           throw new RuntimeException(sprintf(
               'Could not parse body: %s',
               json_last_error_msg()
           ));
       }
       $name = $json['name'] ?? $name;
       file_put_contents('./a.txt', $name);
   }
   $queryString = $request->getQueryParams();
   $name = $queryString['name'] ?? $name;

try {
$filename = './a.xlsx';
$a = new excel();
   $a->a($filename);
      header('Content-Description: File Transfer');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");
header('Content-Disposition: attachment; filename="test.xlsx"');
header('Content-Length: ' . filesize($filename));
header('Pragma: public');
readfile($filename);exit;
} catch (\Exception $e) {
    echo $e->getFile().'('.$e->getLine().'): '.$e->getMessage()."\n";
            echo $e->getTraceAsString();
}

   


//    return sprintf('Hello, %s!', htmlspecialchars($name));
}

// class excel
// {
//     const SHEET_NAME = 'Test';

//     public function a(string $file){
//         $book = new Spreadsheet();
// 		$this->sheet = $book->getActiveSheet();
// 		$this->sheet->setTitle(self::SHEET_NAME);
//         $res = [
//             'hahaah', 'google'
//         ];
//         $this->sheet->fromArray($res, null, 'A1', true);
//         $this->sheet->setSelectedCell('A1');

// 		$writer = IOFactory::createWriter($book, 'Xlsx');
//         $writer->save($file);
//     }
// }

//  function a(string $file){
//         $book = new Spreadsheet();
// 		$this->sheet = $book->getActiveSheet();
// 		$this->sheet->setTitle(self::SHEET_NAME);
//         $res = [
//             'hahaah', 'google'
//         ];
//         $this->sheet->fromArray($res, null, 'A1', true);
//         $this->sheet->setSelectedCell('A1');

// 		$writer = IOFactory::createWriter($book, 'Xlsx');
//         $writer->save($file);
//     }