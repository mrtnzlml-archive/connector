<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Pressure;

use Adeira\Connector\PhysicalUnits\{
	ICalculator, SimpleCalculator
};

class Pressure
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

	/**
	 * Pressure value should be in basic SI units.
	 */
	public function __construct($pressureValue, IPressureUnit $pressureUnit, /*ICalculator*/ $calculator = SimpleCalculator::class)
	{
		$this->pressureValue = $pressureValue;
		$this->pressureUnit = $pressureUnit;
		$this->calculator = new $calculator; //FIXME: should be instance if ICalculator
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

	public function convert(IPressureUnit $toPressureUnit)
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
