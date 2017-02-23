<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\DomainModel\Camera;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Authentication\DomainModel\User\User;
use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\DomainModel\Camera\{
	Camera, CameraId
};
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class CameraTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatItIsPossibleToGetAllRequiredAttributes()
	{
		$dataSource = new Camera(
			CameraId::create(Uuid::fromString('58d200ad-6376-4c01-9b6d-2ea536f1cd2c')),
			new Owner(new User(UserId::create(), 'User Name')),
			'Camera Name',
			new \DateTimeImmutable
		);

		Assert::type(CameraId::class, $dataSource->id());
		Assert::same('58d200ad-6376-4c01-9b6d-2ea536f1cd2c', (string)$dataSource->id());
		Assert::same('Camera Name', $dataSource->cameraName());
	}

}

(new CameraTest)->run();
