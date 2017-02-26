<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Devices\Application\Service\WeatherStation\ViewAllWeatherStationRecords;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStation as WS;
use Adeira\Connector\GraphQL\Context;

final class WeatherStation
{

	private $allWsRecords;

	public function __construct(ViewAllWeatherStationRecords $allWsRecords)
	{
		$this->allWsRecords = $allWsRecords;
	}

	public function id(WS $ws, array $args, Context $context): string
	{
		return (string)$ws->id();
	}

	public function name(WS $ws, array $args, Context $context): string
	{
		return $ws->deviceName();
	}

	public function allRecords(WS $ws, array $args, Context $context)
	{
		$first = $args['first']; // first is required
		$gap = $args['gap'] ?? 1;
		$untilDate = $args['untilDate'] ?? new \DateTimeImmutable;

		$this->allWsRecords->buffer($ws);

		$userId = $context->userId();
		return new \GraphQL\Deferred(function () use ($userId, $ws, $untilDate, $first, $gap) {
			return $this->allWsRecords->execute($userId, $ws->id(), $untilDate, $first, $gap);
		});
	}

}
