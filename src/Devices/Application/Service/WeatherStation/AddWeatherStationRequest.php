<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\User\UserId;

/**
 * AddWeatherStationRequest is just simple DTO and should be filled by form in presenter.
 *  - use primitives
 *  - make it serializable
 *  - no business logic
 *  - no tests
 */
class AddWeatherStationRequest
{

	use \Nette\SmartObject;

	private $weatherStationName;

	private $userId;

	public function __construct(string $weatherStationName, UserId $userId)
	{
		$this->weatherStationName = $weatherStationName;
		$this->userId = $userId;
	}

	public function name(): string
	{
		return $this->weatherStationName;
	}

	public function userId(): UserId
	{
		return $this->userId;
	}

}
