<?php
namespace App;

class DB
{
	function conn(string $username, string $password, string $dbName, string $instanceUnixSocket)
	{
		// Connect using UNIX sockets
		$dsn = sprintf(
			'mysql:dbname=%s;unix_socket=%s',
			$dbName,
			$instanceUnixSocket
		);

		// Connect to the database.
		$conn = new \PDO(
			$dsn,
			$username,
			$password,
			# ...
		);
		return $conn;
	}
}