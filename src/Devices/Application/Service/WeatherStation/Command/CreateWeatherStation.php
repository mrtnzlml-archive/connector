<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation\Command;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;
use Adeira\Connector\ServiceBus\DomainModel\ICommand;

/**
 * This is just simple DTO and should be filled by form in presenter or by command in CLI.
 *  - use primitives
 *  - make it serializable
 *  - no business logic
 *  - no tests
 */
final class CreateWeatherStation implements ICommand
{

	private $stationId;

	private $weatherStationName;

	private $userId;

	public function __construct(WeatherStationId $stationId, string $weatherStationName, UserId $userId)
	{
		$this->stationId = $stationId;
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

	public function stationId()
	{
		return $this->stationId;
	}

}
