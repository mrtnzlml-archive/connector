<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel;

use Adeira\Connector\PhysicalUnits\Speed\Speed;
use Adeira\Connector\PhysicalUnits\Speed\Units\ISpeedUnit;
use Adeira\Connector\PhysicalUnits\Speed\Units\Kmh;

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
		return $this->speed ? $this->speed->convertTo($unit)->value() : NULL;
	}

	public function directionAzimuth(): ?float
	{
		return $this->direction ?? NULL;
	}

	public function gust(string $unit = Kmh::class): ?float
	{
		return $this->gust ? $this->gust->convertTo($unit)->value() : NULL;
	}

}
