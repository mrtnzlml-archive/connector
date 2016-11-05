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
	 * @var DataSourceId
	 */
	private $id;

	public function __construct(DataSourceId $id)
	{
		$this->id = $id;
	}

	public function id(): DataSourceId
	{
		return $this->id;
	}

}
