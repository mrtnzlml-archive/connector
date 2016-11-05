<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Application\Exceptions;

use Adeira\Connector\Inbound\DomainModel\DataSource\DataSourceId;

class DataSourceDoesNotExistException extends \Exception
{

	public function __construct(DataSourceId $dataSourceId)
	{
		parent::__construct("Data source with ID $dataSourceId does not exist.");
	}

}
