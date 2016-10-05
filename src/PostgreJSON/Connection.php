<?php declare(strict_types = 1);

namespace App\PostgreJSON;

class Connection
{

	/** @var \PDO */
	private $pdo;

	public function __construct($username, $password, $database)
	{
		$this->pdo = new \PDO("pgsql:host=127.0.0.1;dbname=$database;user=$username;password=$password");
	}

	/**
	 * @return \PDO
	 */
	public function getPDO()
	{
		return $this->pdo;
	}

}
