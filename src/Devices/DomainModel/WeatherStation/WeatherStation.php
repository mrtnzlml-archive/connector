<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\DomainModel\PhysicalQuantities;

/**
 * This is entity without mapping. Mapping is infrastructure detail.
 *
 * @see Infrastructure/Persistence/Doctrine/Mapping/Adeira.Connector.Devices.DomainModel.WeatherStation.WeatherStation.dcm.xml
 */
final class WeatherStation
{

	/**
	 * @var WeatherStationId
	 */
	private $id;

	/**
	 * @var UserId
	 */
	private $ownerId;

	/**
	 * @var string
	 */
	private $deviceName;

	/**
	 * @var \DateTimeImmutable
	 */
	private $creationDate;

	public function __construct(WeatherStationId $id, Owner $owner, string $deviceName, \DateTimeImmutable $creationDate)
	{
		$this->id = $id;
		$this->ownerId = $owner->id();
		$this->deviceName = $deviceName;
		$this->creationDate = $creationDate;
	}

	public function id(): WeatherStationId
	{
		return $this->id;
	}

	public function ownerId(): UserId
	{
		return $this->ownerId;
	}

	public function deviceName(): string
	{
		return $this->deviceName;
	}

	public function creationDate()
	{
		return $this->creationDate;
	}

	/**
	 * Weather station records doesn't belong to the same aggregate because there are no true invariants needed to protect.
	 * Both (weather stations and records) can be handled separately if needed. This is why it's here return instead of collection.
	 */
	public function makeWeatherStationRecord(WeatherStationRecordId $weatherStationRecordId, PhysicalQuantities $physicalQuantities): WeatherStationRecord
	{
		return new WeatherStationRecord(
			$weatherStationRecordId,
			$this->id,
			$physicalQuantities
		);
	}

}
