<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\PhysicalUnits\Infrastructure\DomainModel\Doctrine;

use Adeira\Connector\PhysicalUnits\DomainModel\Temperature\Temperature;
use Adeira\Connector\PhysicalUnits\DomainModel\Temperature\Units\Celsius;
use Adeira\Connector\PhysicalUnits\DomainModel\Temperature\Units\Kelvin;
use Adeira\Connector\PhysicalUnits\Infrastructure\DomainModel\Doctrine\DoctrineTemperatureType;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\Type as DBAL;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class DoctrineTemperatureTypeTest extends \Adeira\Connector\Tests\TestCase
{

	public function testBasicFunctionality()
	{
		DBAL::addType($name = 'Temperature', DoctrineTemperatureType::class);

		$type = DBAL::getType($name);
		Assert::type(DoctrineTemperatureType::class, $type);
		Assert::same('Temperature', $type->getName());
		Assert::same('DOUBLE PRECISION', $type->getSQLDeclaration([], new PostgreSqlPlatform));

		/** @var Temperature $phpValue */
		$phpValue = $type->convertToPHPValue('1', new PostgreSqlPlatform);
		Assert::type(Temperature::class, $phpValue);
		Assert::same(1.0, $phpValue->value());
		Assert::type(Celsius::class, $phpValue->unit());

		Assert::same(NULL, $type->convertToDatabaseValue('1', new PostgreSqlPlatform));
		Assert::same(1.0, $type->convertToDatabaseValue(new Temperature(new Celsius(1)), new PostgreSqlPlatform));
		Assert::same(-272.15, $type->convertToDatabaseValue(new Temperature(new Kelvin(1)), new PostgreSqlPlatform));
	}

}

(new DoctrineTemperatureTypeTest)->run();
