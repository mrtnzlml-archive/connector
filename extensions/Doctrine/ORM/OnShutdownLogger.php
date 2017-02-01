<?php declare(strict_types = 1);

namespace Adeira\Connector\Doctrine\ORM;

final class OnShutdownLogger
{

	private $sqlLogger;

	public function __construct(\Doctrine\DBAL\Connection $connection)
	{
		$this->sqlLogger = $connection->getConfiguration()->getSQLLogger();
	}

	public function __invoke()
	{
		if (!$this->sqlLogger instanceof \Doctrine\DBAL\Logging\DebugStack) {
			return;
		}
		$queries = $this->sqlLogger->queries;
		if ($queries) {
			foreach ($queries as $query) {
				$this->logQuery($query['sql']);
			}
			$this->logQuery(NULL);
		}
	}

	private function logQuery($query)
	{
		$file = \Tracy\Debugger::$logDirectory . '/sql.log';
		if (!@file_put_contents($file, $query . PHP_EOL, FILE_APPEND | LOCK_EX)) { // @ is escalated to exception
			throw new \RuntimeException("Unable to write to log file '$file'. Is directory writable?");
		}
	}

}
