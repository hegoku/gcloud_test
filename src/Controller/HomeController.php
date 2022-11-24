<?php
namespace App\Controller;

use App\DB;
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

	public function db()
	{
		$username = getenv('db_uesr');
		$password = getenv('db_pwd');
		$dbName = getenv('db_name');
		$instanceUnixSocket = getenv('db_socket');
		
		$db = new DB();
		$conn = $db->conn($username, $password, $dbName, $instanceUnixSocket);

		$sth = $conn->prepare("SELECT * FROM file");
		$sth->execute();

		/* Fetch all of the remaining rows in the result set */
		print("Fetch all of the remaining rows in the result set:\n");
		$result = $sth->fetchAll();
		print_r($result);
	}
}