<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation\Command;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;

/**
 * This is just simple DTO and should be filled by form in presenter or by command in CLI.
 *  - use primitives
 *  - make it serializable
 *  - no business logic
 *  - no tests
 */
final class RenameWeatherStation implements \Adeira\Connector\ServiceBus\DomainModel\ICommand
{

	/**
	 * @var \Adeira\Connector\Authentication\DomainModel\User\UserId
	 */
	private $userId;

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId
	 */
	private $stationId;

	/**
	 * @var string
	 */
	private $newName;

	public function __construct(UserId $userId, WeatherStationId $stationId, string $newName)
	{
		$this->userId = $userId;
		$this->stationId = $stationId;
		$this->newName = $newName;
	}

	public function userId(): UserId
	{
		return $this->userId;
	}

	public function weatherStationId(): WeatherStationId
	{
		return $this->stationId;
	}

	public function newStationName(): string
	{
		return $this->newName;
	}

}
