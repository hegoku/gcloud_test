<?php
namespace App;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Excel
{
    const SHEET_NAME = 'Test';

    public function a(string $file){
        $book = new Spreadsheet();
		$this->sheet = $book->getActiveSheet();
		$this->sheet->setTitle(self::SHEET_NAME);
        $res = [
            'hahaah', 'google'
        ];
        $this->sheet->fromArray($res, null, 'A1', true);
        $this->sheet->setSelectedCell('A1');

		$writer = IOFactory::createWriter($book, 'Xlsx');
        $writer->save($file);
    }
}