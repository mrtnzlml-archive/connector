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
		return $this->nullableFloat($this->indoor, $unit);
	}

	public function outdoor(string $unit = Percentage::class): ?float
	{
		return $this->nullableFloat($this->outdoor, $unit);
	}

	private function nullableFloat(?RelativeHumidity $quantity, string $unit)
	{
		return $quantity ? round($quantity->convertTo($unit)->value(), 2) : NULL;
	}

}
