<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel;

final class PhysicalQuantities
{

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\Pressure
	 */
	private $pressure;

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\Temperature
	 */
	private $temperature;

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\Humidity
	 */
	private $humidity;

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\Wind
	 */
	private $wind;

	public function __construct(Pressure $pressure, Temperature $temperature, Humidity $humidity, Wind $wind)
	{
		$this->pressure = $pressure;
		$this->temperature = $temperature;
		$this->humidity = $humidity;
		$this->wind = $wind;
	}

	public function pressure(): Pressure
	{
		return $this->pressure;
	}

	public function temperature(): Temperature
	{
		return $this->temperature;
	}

	public function humidity(): Humidity
	{
		return $this->humidity;
	}

	public function wind(): Wind
	{
		return $this->wind;
	}

}
