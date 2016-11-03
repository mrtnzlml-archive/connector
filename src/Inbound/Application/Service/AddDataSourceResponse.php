<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Application\Service;

use Adeira\Connector\Inbound\DomainModel;

class AddDataSourceResponse
{

	use \Nette\SmartObject;

	/**
	 * @var \Adeira\Connector\Inbound\DomainModel\DataSource\IDataSourceId
	 */
	private $id;

	public function __construct(DomainModel\DataSource\IDataSourceId $id)
	{
		$this->id = $id;
	}

	public function id(): string
	{
		return (string)$this->id;
	}

}
