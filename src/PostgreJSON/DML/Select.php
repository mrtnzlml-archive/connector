<?php declare(strict_types = 1);

namespace App\PostgreJSON\DML;

use App\PostgreJSON\Connection;

class Select
{

	private $pdo;

	public function __construct(Connection $connection)
	{
		$this->pdo = $connection->getPDO();
	}

	public function text()
	{
		$stmt = $this->pdo->query("SELECT id, data#>>'{name}' AS name FROM incoming");
		bdump($stmt->fetchAll(\PDO::FETCH_ASSOC), __METHOD__);
	}

}
