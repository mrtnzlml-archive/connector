<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\PhysicalUnits\Temperature;

use Adeira\Connector\PhysicalUnits\Temperature\Temperature;
use Adeira\Connector\PhysicalUnits\Temperature\Units\{
	Celsius, Fahrenheit, Kelvin
};
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
class TemperatureTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatItsNotPossibleToConvertToTheUnknownUnit()
	{
		Assert::exception(function () {
			$celsius = new Temperature(new Celsius(100));
			Assert::equal(373.15, $celsius->convertTo('unknown')->value());
		}, \OutOfBoundsException::class, "Cannot convert 'Celsius' -> 'unknown' because conversion is unknown.");
	}

	public function testThatConversionFromCelsiusWorks()
	{
		$celsius = new Temperature(new Celsius(100));
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(100, $celsius->convertTo(Celsius::class)->value());
		Assert::equal(212, $celsius->convertTo(Fahrenheit::class)->value());
		Assert::equal(373.15, $celsius->convertTo(Kelvin::class)->value());
	}

	public function testThatConversionFromFahrenheitWorks()
	{
		$fahrenheit = new Temperature(new Fahrenheit(100));
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(37.7777777777, $fahrenheit->convertTo(Celsius::class)->value());
		Assert::equal(100, $fahrenheit->convertTo(Fahrenheit::class)->value());
		Assert::equal(310.9277777777, $fahrenheit->convertTo(Kelvin::class)->value());
	}

	public function testThatConversionFromKelvinWorks()
	{
		$kelvin = new Temperature(new Kelvin(100));
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(-173.15, $kelvin->convertTo(Celsius::class)->value());
		Assert::equal(-279.67, $kelvin->convertTo(Fahrenheit::class)->value());
		Assert::equal(100, $kelvin->convertTo(Kelvin::class)->value());
	}

}

(new TemperatureTest)->run();
