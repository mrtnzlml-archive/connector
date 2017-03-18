<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\WeatherStation\Type;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationRecord as Record;

final class WeatherStationRecordResolver
{

	public function id(Record $wsr): string
	{
		return $wsr->id()->toString();
	}

	public function creationDate(Record $wsr): \DateTimeImmutable
	{
		return $wsr->creationDate();
	}

}
