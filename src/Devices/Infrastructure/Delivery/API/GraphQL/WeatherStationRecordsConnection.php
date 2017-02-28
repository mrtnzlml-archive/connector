<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Devices\DomainModel\WeatherStation\IAllWeatherStationRecords;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationRecord;
use Adeira\Connector\GraphQL\Context;

final class WeatherStationRecordsConnection
{

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\WeatherStation\IAllWeatherStationRecords
	 */
	private $allRecords;

	public function __construct(IAllWeatherStationRecords $allRecords)
	{
		$this->allRecords = $allRecords;
	}

	/**
	 * @param WeatherStationRecord[] $wsr
	 *
	 * @return int
	 */
	public function totalCount(array $wsr, array $args, Context $context): int
	{
		$singleRecord = $wsr[0];
		return $this->allRecords->totalCount($singleRecord->weatherStationId());
	}

	public function returnedCount(array $wsr, array $args, Context $context): int
	{
		return count($wsr);
	}

	/**
	 * @param WeatherStationRecord[] $wsr
	 *
	 * @return WeatherStationRecord[]
	 */
	public function records(array $wsr, array $args, Context $context): array
	{
		return $wsr; // fall through
	}

}
