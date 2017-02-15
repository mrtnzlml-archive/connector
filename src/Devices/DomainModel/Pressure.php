<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel;

use Adeira\Connector\PhysicalUnits\Pressure\Pressure as PressureQuantity;
use Adeira\Connector\PhysicalUnits\Pressure\Units\{
	IPressureUnit, Pascal
};

final class Pressure
{

	private $absolutePressure;

	private $relativePressure;

	public function __construct(IPressureUnit $absolutePressure, IPressureUnit $relativePressure)
	{
		$this->absolutePressure = (new PressureQuantity($absolutePressure))
			->convertTo(Pascal::class)
			->value();

		$this->relativePressure = (new PressureQuantity($relativePressure))
			->convertTo(Pascal::class)
			->value();
	}

	/**
	 * @return float in Pascal
	 */
	public function absolute(): float
	{
		return $this->absolutePressure;
	}

	/**
	 * @return float in Pascal
	 */
	public function relative(): float
	{
		return $this->relativePressure;
	}

}
