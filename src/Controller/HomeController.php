<?php
namespace App\Controller;

use App\Excel;

class HomeController
{
	public function a()
	{
		print "Hello, World!\n";
	}

	public function excel()
	{
		$filename = './a.xlsx';
		$a = new Excel();
		$a->a($filename);
		try {
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
	}
}