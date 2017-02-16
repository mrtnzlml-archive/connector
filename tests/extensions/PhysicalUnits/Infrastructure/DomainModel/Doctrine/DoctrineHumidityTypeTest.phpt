<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\PhysicalUnits\Infrastructure\DomainModel\Doctrine;

use Adeira\Connector\PhysicalUnits\DomainModel\Humidity\RelativeHumidity;
use Adeira\Connector\PhysicalUnits\DomainModel\Humidity\Units\Percentage;
use Adeira\Connector\PhysicalUnits\Infrastructure\DomainModel\Doctrine\DoctrineHumidityType;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\Type as DBAL;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class DoctrineHumidityTypeTest extends \Adeira\Connector\Tests\TestCase
{

	public function testBasicFunctionality()
	{
		DBAL::addType($name = 'Humidity', DoctrineHumidityType::class);

		$type = DBAL::getType($name);
		Assert::type(DoctrineHumidityType::class, $type);
		Assert::same('Humidity', $type->getName());
		Assert::same('DOUBLE PRECISION', $type->getSQLDeclaration([], new PostgreSqlPlatform));

		/** @var RelativeHumidity $phpValue */
		$phpValue = $type->convertToPHPValue('1', new PostgreSqlPlatform);
		Assert::type(RelativeHumidity::class, $phpValue);
		Assert::same(1.0, $phpValue->value());
		Assert::type(Percentage::class, $phpValue->unit());

		Assert::same(NULL, $type->convertToDatabaseValue('1', new PostgreSqlPlatform));
		Assert::same(1.0, $type->convertToDatabaseValue(new RelativeHumidity(new Percentage(1)), new PostgreSqlPlatform));
	}

}

(new DoctrineHumidityTypeTest)->run();
