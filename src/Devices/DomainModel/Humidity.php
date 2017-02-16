<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel;

use Adeira\Connector\PhysicalUnits\DomainModel\Humidity\RelativeHumidity;
use Adeira\Connector\PhysicalUnits\DomainModel\Humidity\Units\IHumidityUnit;
use Adeira\Connector\PhysicalUnits\DomainModel\Humidity\Units\Percentage;

final class Humidity
{

	private $indoor;

	private $outdoor;

	public function __construct(?IHumidityUnit $indoor, ?IHumidityUnit $outdoor)
	{
		$this->indoor = $indoor ? new RelativeHumidity($indoor) : NULL;
		$this->outdoor = $outdoor ? new RelativeHumidity($outdoor) : NULL;
	}

	public function indoor(string $unit = Percentage::class): ?float
	{
		return $this->indoor ? $this->indoor->convertTo($unit)->value() : NULL;
	}

	public function outdoor(string $unit = Percentage::class): ?float
	{
		return $this->outdoor ? $this->outdoor->convertTo($unit)->value() : NULL;
	}

}
