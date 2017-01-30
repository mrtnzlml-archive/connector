<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

interface IFileLoader
{

	//FIXME: naming?
	public function yieldWeatherStationRecord(string $fileName): \Generator;

}
