<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\PhysicalUnits\DomainModel\Pressure;

use Adeira\Connector\PhysicalUnits\DomainModel\Pressure\Pressure;
use Adeira\Connector\PhysicalUnits\DomainModel\Pressure\Units\{
	Atm, Bar, Pascal, Torr
};
use Adeira\Connector\PhysicalUnits\DomainModel\Speed\Units\Kmh;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class PressureTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatPressureAdditionIsImmutable()
	{
		$p1 = $p2 = new Pressure(new Pascal(2500));
		$p1 = $p1->add(new Pressure(new Pascal(500)));
		Assert::same(3000.0, $p1->value());
		Assert::same(2500.0, $p2->value());
	}

	public function testThatAdditionWithWrongUnitsThrowsException()
	{
		$pressure = new Pressure(new Pascal(2500));
		Assert::exception(function () use ($pressure) {
			$pressure->add(new Pressure(new Bar(500)));
		}, \InvalidArgumentException::class, 'Pressure units must be identical.');
	}

	public function testThatPressureSubstractionIsImmutable()
	{
		$p1 = $p2 = new Pressure(new Pascal(2500));
		$p1 = $p1->substract(new Pressure(new Pascal(500)));
		Assert::same(2000.0, $p1->value());
		Assert::same(2500.0, $p2->value());
	}

	public function testThatSubstractionWithWrongUnitsThrowsException()
	{
		$pressure = new Pressure(new Pascal(2500));
		Assert::exception(function () use ($pressure) {
			$pressure->substract(new Pressure(new Bar(500)));
		}, \InvalidArgumentException::class, 'Pressure units must be identical.');
	}

	public function testThatConversionFromAtmWorks()
	{
		$atm = new Pressure(new Atm(1000));
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(1000.0, $atm->convertTo(Atm::class)->value());
		Assert::equal(1013.25, $atm->convertTo(Bar::class)->value());
		Assert::equal(101325000.0, $atm->convertTo(Pascal::class)->value());
		Assert::equal(760000.0, $atm->convertTo(Torr::class)->value());
	}

	public function testThatConversionFromBarWorks()
	{
		$bar = new Pressure(new Bar(1000));
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(986.9232667160, $bar->convertTo(Atm::class)->value());
		Assert::equal(1000.0, $bar->convertTo(Bar::class)->value());
		Assert::equal(100000000.0, $bar->convertTo(Pascal::class)->value());
		Assert::equal(750061.682704, $bar->convertTo(Torr::class)->value());
	}

	public function testThatConversionFromPascalWorks()
	{
		$pascal = new Pressure(new Pascal(1000));
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(0.0098692327, $pascal->convertTo(Atm::class)->value());
		Assert::equal(0.01, $pascal->convertTo(Bar::class)->value());
		Assert::equal(1000.0, $pascal->convertTo(Pascal::class)->value());
		Assert::equal(7.5006168270, $pascal->convertTo(Torr::class)->value());
	}

	public function testThatConversionFromTorrWorks()
	{
		$torr = new Pressure(new Torr(1000));
		//Tester\Assert::EPSILON === 1e-10
		Assert::equal(1.3157894737, $torr->convertTo(Atm::class)->value());
		Assert::equal(1.3332236842, $torr->convertTo(Bar::class)->value());
		Assert::equal(133322.368421, $torr->convertTo(Pascal::class)->value());
		Assert::equal(1000.0, $torr->convertTo(Torr::class)->value());
	}

	public function testThatItAlwaysReturnsFloat()
	{
		Assert::same(1.0, (new Pressure(new Atm('1')))->value());
		Assert::same(1.0, (new Pressure(new Bar('1')))->value());
		Assert::same(1.0, (new Pressure(new Pascal('1')))->value());
		Assert::same(1.0, (new Pressure(new Torr('1')))->value());
	}

	public function testThatItsNotPossibleToconvertToPressureToSpeed()
	{
		$torr = new Pressure(new Torr(1000));
		Assert::exception(function () use ($torr) {
			$torr->convertTo(Kmh::class);
		}, \OutOfBoundsException::class, "Cannot convert 'Torr' -> 'Kmh' because conversion is unknown.");
	}

}

(new PressureTest)->run();
