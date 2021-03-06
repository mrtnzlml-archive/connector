<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\Infrastructure\DomainModel\Camera\Doctrine;

use Adeira\Connector\Devices\DomainModel\Camera\CameraId;
use Adeira\Connector\Devices\Infrastructure\DomainModel\Camera\Doctrine\DoctrineCameraIdType;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\Type as DBAL;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class DoctrineCameraIdTypeTest extends \Adeira\Connector\Tests\TestCase
{

	public function testGetTypeName()
	{
		DBAL::addType($name = 'My Type', DoctrineCameraIdType::class);
		$type = DBAL::getType($name);

		Assert::type(DoctrineCameraIdType::class, $type);
		Assert::same('CameraId', $type->getName());
		Assert::same('UUID', $type->getSQLDeclaration([], new PostgreSqlPlatform));
	}

	public function testConvertToPHPValue()
	{
		DBAL::addType($name = 'My Type', DoctrineCameraIdType::class);
		$type = DBAL::getType($name);

		Assert::equal(
			CameraId::createFromString($uuid = '00000000-0000-0000-0000-000000000000'),
			$type->convertToPHPValue($uuid, new PostgreSqlPlatform)
		);
	}

}

(new DoctrineCameraIdTypeTest)->run();
