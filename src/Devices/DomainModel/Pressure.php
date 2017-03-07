<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel;

use Adeira\Connector\PhysicalUnits\DomainModel\Pressure\Pressure as PressureQuantity;
use Adeira\Connector\PhysicalUnits\DomainModel\Pressure\Units\{
	IPressureUnit, Pascal
};

final class Pressure
{

	private $absolutePressure;

	private $relativePressure;

	public function __construct(?IPressureUnit $absolutePressure, ?IPressureUnit $relativePressure)
	{
		$this->absolutePressure = $absolutePressure ? new PressureQuantity($absolutePressure) : NULL;
		$this->relativePressure = $relativePressure ? new PressureQuantity($relativePressure) : NULL;
	}

	public function absolute(string $unit = Pascal::class): ?float
	{
		return $this->nullableFloat($this->absolutePressure, $unit);
	}

	public function relative(string $unit = Pascal::class): ?float
	{
		return $this->nullableFloat($this->relativePressure, $unit);
	}

	private function nullableFloat(?PressureQuantity $quantity, string $unit)
	{
		return $quantity ? round($quantity->convertTo($unit)->value(), 2) : NULL;
	}

}
