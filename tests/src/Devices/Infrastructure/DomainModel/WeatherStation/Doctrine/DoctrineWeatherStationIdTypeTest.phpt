<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\Infrastructure\DomainModel\WeatherStation\Doctrine;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;
use Adeira\Connector\Devices\Infrastructure\DomainModel\WeatherStation\Doctrine\DoctrineWeatherStationIdType;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\Type as DBAL;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class DoctrineWeatherStationIdTypeTest extends \Adeira\Connector\Tests\TestCase
{

	public function testGetTypeName()
	{
		DBAL::addType($name = 'My Doctrine Type', DoctrineWeatherStationIdType::class);
		$type = DBAL::getType($name);

		Assert::type(DoctrineWeatherStationIdType::class, $type);
		Assert::same('WeatherStationId', $type->getName());
		Assert::same('UUID', $type->getSQLDeclaration([], new PostgreSqlPlatform));
	}

	public function testConvertToPHPValue()
	{
		DBAL::addType($name = 'My Doctrine Type', DoctrineWeatherStationIdType::class);
		$type = DBAL::getType($name);

		Assert::equal(
			WeatherStationId::createFromString($uuid = '00000000-0000-0000-0000-000000000000'),
			$type->convertToPHPValue($uuid, new PostgreSqlPlatform)
		);
	}

}

(new DoctrineWeatherStationIdTypeTest)->run();
