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

	/**
	 * @var array
	 */
	private $data;

	public function __construct(string $weatherStationId, string $jsonData)
	{
		$this->weatherStationId = $weatherStationId;
		$this->data = Json::decode($jsonData, Json::FORCE_ARRAY);
	}

	public function weatherStationId(): string
	{
		return $this->weatherStationId;
	}

	public function data(): array
	{
		return $this->data;
	}

}
