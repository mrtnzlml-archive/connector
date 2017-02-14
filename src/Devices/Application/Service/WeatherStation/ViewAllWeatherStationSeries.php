<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\DomainModel\WeatherStation\IAllWeatherStationSeries;

final class ViewAllWeatherStationSeries
{

	private $seriesRepository;

	public function __construct(IAllWeatherStationSeries $seriesRepository)
	{
		$this->seriesRepository = $seriesRepository;
	}

	public function execute(UserId $userId)
	{
		return $this->seriesRepository->all();
	}

}
