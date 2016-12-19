<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\DomainModel\DataSource;

use Adeira\Connector\Authentication\DomainModel\User\User;
use Adeira\Connector\Inbound\DomainModel\DataSourceRecord\DataSourceRecord;
use Adeira\Connector\Inbound\DomainModel\DataSourceRecord\DataSourceRecordId;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This is entity without mapping. Mapping is infrastructure detail.
 *
 * @see Infrastructure/Persistence/Doctrine/Mapping/Adeira.Connector.Inbound.DomainModel.DataSource.DataSource.dcm.xml
 */
class DataSource
{

	/**
	 * @var \Adeira\Connector\Inbound\DomainModel\DataSource\DataSourceId
	 */
	private $id;

	/**
	 * @var ArrayCollection | User[]
	 */
	private $owners;

	/**
	 * @var string
	 */
	private $deviceName;

	/**
	 * TODO: maybe instead of User use actual Owner to prevent bypasing Owner check
	 */
	public function __construct(DataSourceId $id, User $owner, string $deviceName)
	{
		$this->id = $id;

		$this->owners = new ArrayCollection;
		$this->owners->add($owner);

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
