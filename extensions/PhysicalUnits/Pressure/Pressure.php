<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Pressure;

use Adeira\Connector\PhysicalUnits\{
	ICalculator, IPhysicalQuantity, IUnit, Pressure\Units\IPressureUnit, SimpleCalculator
};

class Pressure implements IPhysicalQuantity
{

	private $pressureValue;

	/**
	 * @var IPressureUnit
	 */
	private $pressureUnit;

	/**
	 * @var ICalculator
	 */
	private $calculator;

	public function __construct($pressureValue, IPressureUnit $pressureUnit, ICalculator $calculator = NULL)
	{
		$this->pressureValue = $pressureValue;
		$this->pressureUnit = $pressureUnit;
		$this->calculator = $calculator ?? new SimpleCalculator;
	}

	public function getPressureValue()
	{
		return $this->pressureValue;
	}

	public function getPressureUnit()
	{
		return $this->pressureUnit;
	}

	public function add(Pressure $increment): self
	{
		$this->assertSamePressureUnit($increment);
		return new self(
			$this->calculator->add($this->pressureValue, $increment->pressureValue),
			$this->pressureUnit
		);
	}

	public function substract(Pressure $decrement): self
	{
		$this->assertSamePressureUnit($decrement);
		return new self(
			$this->calculator->substract($this->pressureValue, $decrement->pressureValue),
			$this->pressureUnit
		);
	}

	public function convert(IUnit $toPressureUnit): IPhysicalQuantity
	{
		$conversion = new Conversion;
		return $conversion->convert($this, $toPressureUnit);
	}

	private function assertSamePressureUnit(Pressure $pressure)
	{
		if (!$this->pressureUnit instanceof $pressure->pressureUnit) {
			throw new \InvalidArgumentException('Pressure units must be identical.');
		}
	}

}
