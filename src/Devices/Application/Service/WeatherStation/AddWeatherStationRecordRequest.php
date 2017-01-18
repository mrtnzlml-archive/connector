<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Nette\Utils\Json;

/**
 * AddWeatherStationRequest is just simple DTO and should be filled by form in presenter.
 *  - use primitives
 *  - make it serializable
 *  - no business logic
 *  - no tests
 */
class AddWeatherStationRecordRequest
{

	/**
	 * @var string
	 */
	private $weatherStationId;

	private $pressure;

	public function __construct(string $weatherStationId, int $pressure)
	{
		$this->weatherStationId = $weatherStationId;
		$this->pressure = $pressure;
	}

	public function weatherStationId(): string
	{
		return $this->weatherStationId;
	}

	public function pressure(): int
	{
		return $this->pressure;
	}

}
