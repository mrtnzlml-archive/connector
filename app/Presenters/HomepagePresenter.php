<?php declare(strict_types = 1);

namespace Adeira\Connector\Presenters;

use Nette\Application\UI;

class HomepagePresenter extends UI\Presenter
{

	public function __construct(\Doctrine\DBAL\Connection $connection)
	{
		parent::__construct();
		bdump($connection->fetchAll("SELECT id, data#>>'{name}' AS name FROM incoming"));
	}

}
