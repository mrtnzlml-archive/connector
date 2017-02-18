<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationSeries as Series;
use Adeira\Connector\GraphQL\Context;

final class WeatherStationSeries
{

	public function id(Series $series, $args, Context $context)
	{
		return $series->id();
	}

	public function name(Series $series, $args, Context $context)
	{
		return $series->code();
	}

}
