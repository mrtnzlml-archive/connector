<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\DomainModel\DataSourceRecord;

use Adeira\Connector\Inbound\DomainModel\DataSource\DataSourceId;

/**
 * This is entity without mapping. Mapping is infrastructure detail.
 *
 * @see Infrastructure/Persistence/Doctrine/Mapping/Adeira.Connector.Inbound.DomainModel.DataSource.DataSourceRecord.dcm.xml
 */
class DataSourceRecord
{

	/**
	 * @var \Adeira\Connector\Inbound\DomainModel\DataSourceRecord\DataSourceRecordId
	 */
	private $id;

	/**
	 * @var \Adeira\Connector\Inbound\DomainModel\DataSource\DataSourceId
	 */
	private $dataSourceId;

	/**
	 * @var array
	 */
	private $data;

	public function __construct(DataSourceRecordId $recordId, DataSourceId $dataSourceId, array $recordData)
	{
		$this->id = $recordId;
		$this->dataSourceId = $dataSourceId;
		$this->data = $recordData;
	}

	public function id(): DataSourceRecordId
	{
		return $this->id;
	}

	public function dataSourceId(): DataSourceId
	{
		return $this->dataSourceId;
	}

	public function data(): array
	{
		return $this->data;
	}

}
