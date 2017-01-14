<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Pressure;

class Pressure
{

	private $pressureValue;

	/**
	 * @var IPressureUnit
	 */
	private $pressureUnit;

	/**
	 * Pressure value should be in basic SI units.
	 */
	public function __construct($pressureValue, IPressureUnit $pressureUnit)
	{
		$this->pressureValue = $pressureValue;
		$this->pressureUnit = $pressureUnit;
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
			$this->pressureValue + $increment->pressureValue,
			$this->pressureUnit
		);
	}

	public function substract(Pressure $decrement): self
	{
		$this->assertSamePressureUnit($decrement);
		return new self(
			$this->pressureValue - $decrement->pressureValue,
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
