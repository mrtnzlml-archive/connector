<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\DomainModel\DataSource;

use Doctrine\ORM\Mapping as ORM;

/**
 * This is entity without mapping. Mapping is infrastructure detail.
 *
 * @see Infrastructure/Persistence/Doctrine/Mapping/Adeira.Connector.Inbound.DomainModel.DataSource.DataSourceRecord.dcm.xml
 */
class DataSourceRecord
{

	/**
	 * @var IDataSourceId
	 */
	private $id;

	/**
	 * @var string JSON
	 */
	private $data;

	public function __construct(IDataSourceId $id)
	{
		$this->id = $id;
	}

}
