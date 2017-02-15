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

	public function __construct(ISpeedUnit $speed, float $azimuth, ISpeedUnit $gust)
	{
		$this->speed = (new Speed($speed))
			->convertTo(Kmh::class)
			->value();

		$this->direction = $azimuth; //FIXME: validace nebo ValueObject (0-360°)

		$this->gust = (new Speed($gust))
			->convertTo(Kmh::class)
			->value();
	}

	/**
	 * @return float in Kmh
	 */
	public function speed(): float
	{
		return $this->speed;
	}

	public function directionAzimuth(): float
	{
		return $this->direction;
	}

	/**
	 * @return float in Kmh
	 */
	public function gust(): float
	{
		return $this->gust;
	}

}
