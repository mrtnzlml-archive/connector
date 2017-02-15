<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel;

use Adeira\Connector\PhysicalUnits\Humidity\Units\IHumidityUnit;
use Adeira\Connector\PhysicalUnits\Humidity\RelativeHumidity;
use Adeira\Connector\PhysicalUnits\Humidity\Units\Percentage;

final class Humidity
{

	private $indoor;

	private $outdoor;

	public function __construct(IHumidityUnit $indoor, IHumidityUnit $outdoor)
	{
		$this->indoor = (new RelativeHumidity($indoor))
			->convertTo(Percentage::class)
			->value();

		$this->outdoor = (new RelativeHumidity($outdoor))
			->convertTo(Percentage::class)
			->value();
	}

	/**
	 * @return float in Percentage
	 */
	public function indoor(): float
	{
		return $this->indoor;
	}

	/**
	 * @return float in Percentage
	 */
	public function outdoor(): float
	{
		return $this->outdoor;
	}

}
