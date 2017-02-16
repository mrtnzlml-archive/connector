<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\PhysicalUnits\Infrastructure\DomainModel\Doctrine;

use Adeira\Connector\PhysicalUnits\DomainModel\Speed\Speed;
use Adeira\Connector\PhysicalUnits\DomainModel\Speed\Units\Kmh;
use Adeira\Connector\PhysicalUnits\DomainModel\Speed\Units\Ms;
use Adeira\Connector\PhysicalUnits\Infrastructure\DomainModel\Doctrine\DoctrineSpeedType;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\Type as DBAL;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class DoctrineSpeedTypeTest extends \Adeira\Connector\Tests\TestCase
{

	public function testBasicFunctionality()
	{
		DBAL::addType($name = 'Speed', DoctrineSpeedType::class);

		$type = DBAL::getType($name);
		Assert::type(DoctrineSpeedType::class, $type);
		Assert::same('Speed', $type->getName());
		Assert::same('DOUBLE PRECISION', $type->getSQLDeclaration([], new PostgreSqlPlatform));

		/** @var Speed $phpValue */
		$phpValue = $type->convertToPHPValue('1', new PostgreSqlPlatform);
		Assert::type(Speed::class, $phpValue);
		Assert::same(1.0, $phpValue->value());
		Assert::type(Kmh::class, $phpValue->unit());

		Assert::same(NULL, $type->convertToDatabaseValue('1', new PostgreSqlPlatform));
		Assert::same(1.0, $type->convertToDatabaseValue(new Speed(new Kmh(1)), new PostgreSqlPlatform));
		Assert::same(3.6, $type->convertToDatabaseValue(new Speed(new Ms(1)), new PostgreSqlPlatform));
	}

}

(new DoctrineSpeedTypeTest)->run();
