<?php declare(strict_types = 1);

namespace Adeira\Connector\Doctrine\ORM\DI;

use Doctrine\DBAL;

final class ConnectionPanel implements \Tracy\IBarPanel
{

	/**
	 * @var \Doctrine\DBAL\Configuration
	 */
	private $configuration;

	/**
	 * @var \Doctrine\DBAL\Connection
	 */
	private $connection;

	private $queriesHashTable = [];

	private $slowestQueryTime = 0;

	public function __construct(DBAL\Connection $connection)
	{
		$configuration = $connection->getConfiguration();
		$configuration->setSQLLogger(new DBAL\Logging\DebugStack);

		$this->configuration = $configuration;
		$this->connection = $connection;
	}

	public function getTab(): string
	{
		/** @var DBAL\Logging\DebugStack $logger */
		$logger = $this->configuration->getSQLLogger();
		$totalTime = $this->getTotalTime($logger->queries);

		ob_start();
		require __DIR__ . '/ConnectionPanel.tab.phtml';
		return ob_get_clean();
	}

	public function getPanel(): string
	{
		/** @var DBAL\Logging\DebugStack $logger */
		$logger = $this->configuration->getSQLLogger();
		$queries = $logger->queries;
		$totalTime = $this->getTotalTime($queries);

		$keywordList = $this->connection->getDatabasePlatform()->getReservedKeywordsList();
		$highlightSql = function ($sql) use ($keywordList) {
			foreach (explode(' ', $sql) as $word) {
				if ($keywordList->isKeyword($word)) {
					yield "<span style='color:blue'>$word</span>";
				} else {
					yield $word;
				}
				yield ' ';
			}
		};

		$outputQueries = [];
		foreach ($queries as $query) {
			$sqlHash = md5($query['sql']);
			$repeated = FALSE;
			if (array_key_exists($sqlHash, $this->queriesHashTable)) {
				$repeated = TRUE;
			} else {
				$this->queriesHashTable[$sqlHash] = TRUE;
			}
			if ($this->slowestQueryTime < $query['executionMS']) {
				$this->slowestQueryTime = $query['executionMS'];
			}
			$outputQueries[] = [
				'executionMS' => number_format($query['executionMS'] * 1000, 3),
				'sql' => $query['sql'],
				'params' => $query['params'],
				'types' => $query['types'],
				'repeated' => $repeated,
			];
		}
		$slowestQueryTime = number_format($this->slowestQueryTime * 1000, 3);

		ob_start();
		require __DIR__ . '/ConnectionPanel.panel.phtml';
		return ob_get_clean();
	}

	private function getTotalTime(array $queries): string
	{
		$totalTime = 0;
		foreach ($queries as $query) {
			$totalTime += $query['executionMS'];
		}
		return number_format($totalTime * 1000, 3);
	}

}
