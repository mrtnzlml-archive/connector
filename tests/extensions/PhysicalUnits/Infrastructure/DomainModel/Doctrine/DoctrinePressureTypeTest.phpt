<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\PhysicalUnits\Infrastructure\DomainModel\Doctrine;

use Adeira\Connector\PhysicalUnits\DomainModel\Pressure\Pressure;
use Adeira\Connector\PhysicalUnits\DomainModel\Pressure\Units\Bar;
use Adeira\Connector\PhysicalUnits\DomainModel\Pressure\Units\Pascal;
use Adeira\Connector\PhysicalUnits\Infrastructure\DomainModel\Doctrine\DoctrinePressureType;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\Type as DBAL;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class DoctrinePressureTypeTest extends \Adeira\Connector\Tests\TestCase
{

	public function testBasicFunctionality()
	{
		DBAL::addType($name = 'Pressure', DoctrinePressureType::class);

		$type = DBAL::getType($name);
		Assert::type(DoctrinePressureType::class, $type);
		Assert::same('Pressure', $type->getName());
		Assert::same('DOUBLE PRECISION', $type->getSQLDeclaration([], new PostgreSqlPlatform));

		/** @var Pressure $phpValue */
		$phpValue = $type->convertToPHPValue('1', new PostgreSqlPlatform);
		Assert::type(Pressure::class, $phpValue);
		Assert::same(1.0, $phpValue->value());
		Assert::type(Pascal::class, $phpValue->unit());

		Assert::same(NULL, $type->convertToDatabaseValue('1', new PostgreSqlPlatform));
		Assert::same(1.0, $type->convertToDatabaseValue(new Pressure(new Pascal(1)), new PostgreSqlPlatform));
		Assert::same(100000.0, $type->convertToDatabaseValue(new Pressure(new Bar(1)), new PostgreSqlPlatform));
	}

}

(new DoctrinePressureTypeTest)->run();
