<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

final class RecordAggregationRange extends \Consistence\Enum\Enum
{

	const HOUR = 'hour';
	const DAY = 'day';
	const WEEK = 'week';
	const MONTH = 'month';

}
