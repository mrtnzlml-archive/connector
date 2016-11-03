<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\DomainModel\DataSource;

/**
 * This is entity without mapping. Mapping is infrastructure detail.
 *
 * @see Infrastructure/Persistence/Doctrine/Mapping/Adeira.Connector.Inbound.DomainModel.DataSource.DataSource.dcm.xml
 */
class DataSource
{

	/**
	 * @var IDataSourceId
	 */
	private $id;

	public function __construct(IDataSourceId $id)
	{
		$this->id = $id;
	}

	public function id()
	{
		return $this->id;
	}

}
