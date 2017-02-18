<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationRecord as Record;
use Adeira\Connector\GraphQL\Context;

final class WeatherStationRecord
{

	public function id(Record $wsr, $args, Context $context)
	{
		return $wsr->id();
	}

	public function indoorTemperature(Record $wsr, $args, Context $context)
	{
		return $wsr->temperature()->indoor();
	}

	public function outdoorTemperature(Record $wsr, $args, Context $context)
	{
		return $wsr->temperature()->outdoor();
	}

}
