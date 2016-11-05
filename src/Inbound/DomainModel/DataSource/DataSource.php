<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\DomainModel\DataSource;

use Adeira\Connector\Inbound\DomainModel\DataSourceRecord\DataSourceRecord;
use Adeira\Connector\Inbound\DomainModel\DataSourceRecord\DataSourceRecordId;

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

	/**
	 * @var string
	 */
	private $deviceName;

	public function __construct(DataSourceId $id, string $deviceName)
	{
		$this->id = $id;
		$this->deviceName = $deviceName;
	}

	public function id(): DataSourceId
	{
		return $this->id;
	}

	public function deviceName(): string
	{
		return $this->deviceName;
	}

	public function makeDataSourceRecord(DataSourceRecordId $dataSourceRecordId, array $recordData): DataSourceRecord
	{
		return new DataSourceRecord(
			$dataSourceRecordId,
			$this->id,
			$recordData
		);
	}

}
