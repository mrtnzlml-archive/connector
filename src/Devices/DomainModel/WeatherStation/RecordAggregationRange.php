<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

final class RecordAggregationRange extends \Consistence\Enum\Enum
{

	public const HOUR = 'hour';
	public const DAY = 'day';
	public const WEEK = 'week';
	public const MONTH = 'month';

}
