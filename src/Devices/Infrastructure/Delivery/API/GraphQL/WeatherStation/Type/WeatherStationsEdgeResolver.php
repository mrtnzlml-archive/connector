<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\WeatherStation\Type;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStation;
use Adeira\Connector\GraphQL\Context;

final class WeatherStationsEdgeResolver
{

	public function cursor(WeatherStation $ws, array $args, Context $context): string
	{
		return base64_encode((string)$ws->id());
	}

	public function node(WeatherStation $ws, array $args, Context $context): WeatherStation
	{
		return $ws; // fall through
	}

}
