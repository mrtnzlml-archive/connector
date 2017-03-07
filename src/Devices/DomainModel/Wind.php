<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel;

use Adeira\Connector\PhysicalUnits\DomainModel\Speed\Speed;
use Adeira\Connector\PhysicalUnits\DomainModel\Speed\Units\ISpeedUnit;
use Adeira\Connector\PhysicalUnits\DomainModel\Speed\Units\Kmh;

final class Wind
{

	private $speed;

	private $direction;

	private $gust;

	public function __construct(?ISpeedUnit $speed, ?float $azimuth, ?ISpeedUnit $gust)
	{
		$this->speed = $speed ? new Speed($speed) : NULL;
		$this->direction = $azimuth; //FIXME: validace nebo ValueObject (0-360°)
		$this->gust = $gust ? new Speed($gust) : NULL;
	}

	public function speed(string $unit = Kmh::class): ?float
	{
		return $this->nullableFloat($this->speed, $unit);
	}

	public function directionAzimuth(): ?float
	{
		return $this->direction ?? NULL;
	}

	public function gust(string $unit = Kmh::class): ?float
	{
		return $this->nullableFloat($this->gust, $unit);
	}

	private function nullableFloat(?Speed $quantity, string $unit)
	{
		return $quantity ? round($quantity->convertTo($unit)->value(), 2) : NULL;
	}

}
