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

	public function __construct(IPressureUnit $pressureUnit)
	{
		$pressureQuantity = new PressureQuantity($pressureUnit);

		$this->absolutePressure = $pressureQuantity
			->convertTo(Pascal::class)
			->value();

		$this->relativePressure = -1; //FIXME
	}

	public function absolute(): int
	{
		return $this->absolutePressure;
	}

	public function relative(): int
	{
		return $this->relativePressure;
	}

}