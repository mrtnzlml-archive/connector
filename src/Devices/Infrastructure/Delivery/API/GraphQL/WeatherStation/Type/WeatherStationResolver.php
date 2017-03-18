<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\WeatherStation\Type;

use Adeira\Connector\Devices\Application\Service\WeatherStation\ViewAggregatedRecords;
use Adeira\Connector\Devices\DomainModel\WeatherStation\RecordAggregationRange;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStation as WS;
use Adeira\Connector\GraphQL\Context;

final class WeatherStationResolver
{

	private $allWsRecords;

	public function __construct(ViewAggregatedRecords $allWsRecords)
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
		$untilDate = $args['untilDate'] ?? new \DateTimeImmutable;
		$aggregation = $args['aggregation'] ?? RecordAggregationRange::HOUR;
		$aggregationEnum = RecordAggregationRange::get($aggregation);

		$userId = $context->userId();
		return $this->allWsRecords->execute($userId, $ws->id(), $untilDate, $first, $aggregationEnum);
	}

}
