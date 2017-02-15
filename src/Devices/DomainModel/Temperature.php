<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel;

use Adeira\Connector\PhysicalUnits\Temperature\Temperature as TemperatureQuantity;
use Adeira\Connector\PhysicalUnits\Temperature\Units\{
	Celsius, ITemperatureUnit
};

final class Temperature
{

	private $indoor;

	private $outdoor;

	public function __construct(ITemperatureUnit $indoor, ITemperatureUnit $outdoor)
	{
		$this->indoor = (new TemperatureQuantity($indoor))
			->convertTo(Celsius::class)
			->value();

		$this->outdoor = (new TemperatureQuantity($outdoor))
			->convertTo(Celsius::class)
			->value();
	}

	/**
	 * @return float in Celsius
	 */
	public function indoor(): float
	{
		return $this->indoor;
	}

	/**
	 * @return float in Celsius
	 */
	public function outdoor(): float
	{
		return $this->outdoor;
	}

}
