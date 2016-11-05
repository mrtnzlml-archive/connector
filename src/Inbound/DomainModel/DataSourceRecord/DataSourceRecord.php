<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\DomainModel\DataSourceRecord;

use Doctrine\ORM\Mapping as ORM;

/**
 * This is entity without mapping. Mapping is infrastructure detail.
 *
 * @see Infrastructure/Persistence/Doctrine/Mapping/Adeira.Connector.Inbound.DomainModel.DataSource.DataSourceRecord.dcm.xml
 */
class DataSourceRecord
{

	/**
	 * @var DataSourceRecordId
	 */
	private $id;

	public function __construct(DataSourceRecordId $id)
	{
		$this->id = $id;
	}

	public function id(): DataSourceRecordId
	{
		return $this->id;
	}

}
