<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Pressure;

use Adeira\Connector\PhysicalUnits\{
	Conversion, ICalculator, IPhysicalQuantity, IUnit, Pressure\Units\IPressureUnit, SimpleCalculator
};

/**
 * Exact conversions:
 * 1 bar = 100.000 Pa
 * 1 atm = 101325 Pa = 760 Torr
 */
final class Pressure implements IPhysicalQuantity
{

	/**
	 * @var IPressureUnit
	 */
	private $pressureUnit;

	/**
	 * @var ICalculator
	 */
	private $calculator;

	public function __construct(IPressureUnit $pressureUnit, ICalculator $calculator = NULL)
	{
		$this->pressureUnit = $pressureUnit;
		$this->calculator = $calculator ?? new SimpleCalculator;
	}

	public function value()
	{
		return $this->pressureUnit->value();
	}

	public function unit(): IUnit
	{
		return $this->pressureUnit;
	}

	public function add(Pressure $increment): self
	{
		$this->assertSamePressureUnit($increment);
		return new self(
			new $this->pressureUnit($this->calculator->add($this->value(), $increment->value()))
		);
	}

	public function substract(Pressure $decrement): self
	{
		$this->assertSamePressureUnit($decrement);
		return new self(
			new $this->pressureUnit($this->calculator->substract($this->value(), $decrement->value()))
		);
	}

	public function convertTo(string $pressureUnit): IPhysicalQuantity
	{
		$conversion = new Conversion;
		return $conversion->convert($this, $pressureUnit);
	}

	private function assertSamePressureUnit(Pressure $pressure)
	{
		if (!$this->pressureUnit instanceof $pressure->pressureUnit) {
			throw new \InvalidArgumentException('Pressure units must be identical.');
		}
	}

}
