<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation\Command;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\DomainModel\PhysicalQuantities;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationRecordId;
use Adeira\Connector\ServiceBus\DomainModel\ICommand;

/**
 * This is just simple DTO and should be filled by form in presenter or by command in CLI.
 *  - use primitives
 *  - make it serializable
 *  - no business logic
 *  - no tests
 */
final class CreateWeatherStationRecord implements ICommand
{

	private $recordId;

	private $stationId;

	private $userId;

	private $quantities;

	public function __construct(WeatherStationRecordId $recordId, WeatherStationId $stationId, UserId $userId, PhysicalQuantities $quantities)
	{
		$this->recordId = $recordId;
		$this->stationId = $stationId;
		$this->userId = $userId;
		$this->quantities = $quantities;
	}

	public function recordId(): WeatherStationRecordId
	{
		return $this->recordId;
	}

	public function stationId(): WeatherStationId
	{
		return $this->stationId;
	}

	public function userId(): UserId
	{
		return $this->userId;
	}

	public function physicalQuantities(): PhysicalQuantities
	{
		return $this->quantities;
	}

}
