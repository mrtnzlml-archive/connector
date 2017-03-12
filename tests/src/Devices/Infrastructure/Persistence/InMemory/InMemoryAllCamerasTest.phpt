<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\Infrastructure\Persistence\InMemory;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Authentication\DomainModel\User\User;
use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\DomainModel\Camera\Camera;
use Adeira\Connector\Devices\DomainModel\Camera\CameraId;
use Adeira\Connector\Devices\Infrastructure\Persistence\InMemory\InMemoryAllCameras;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class InMemoryAllCamerasTest extends \Adeira\Connector\Tests\TestCase
{

	public function test_that_add_works()
	{
		$owner = new Owner(new User(UserId::createFromString('00000000-0000-0000-0000-000000000000'), 'username'));
		$repository = new InMemoryAllCameras;
		Assert::count(0, $repository->belongingTo($owner)->hydrate());
		$repository->add(Camera::create(CameraId::create(), $owner, 'Camera 1'));
		$repository->add(Camera::create(CameraId::create(), $owner, 'Camera 2'));
		$repository->add(Camera::create(CameraId::create(), $owner, 'Camera 3'));
		Assert::count(3, $repository->belongingTo($owner)->hydrate());
	}

	public function test_that_withId_works()
	{
		$owner = new Owner(new User(UserId::createFromString('00000000-0000-0000-0000-000000000000'), 'username'));
		$repository = new InMemoryAllCameras;
		$repository->add(Camera::create($id = CameraId::create(), $owner, 'Camera 1'));
		Assert::type(Camera::class, $repository->withId($id));
		Assert::null($repository->withId(CameraId::create()));
	}

	public function test_that_belongingTo_works()
	{
		$owner1 = new Owner(new User(UserId::createFromString('00000000-0000-0000-0000-000000000001'), 'username1'));
		$owner2 = new Owner(new User(UserId::createFromString('00000000-0000-0000-0000-000000000002'), 'username2'));
		$repository = new InMemoryAllCameras;
		Assert::count(0, $repository->belongingTo($owner1)->hydrate());
		Assert::count(0, $repository->belongingTo($owner2)->hydrate());
		$repository->add(Camera::create(CameraId::create(), $owner1, 'Camera 1'));
		$repository->add(Camera::create(CameraId::create(), $owner2, 'Camera 2'));
		$repository->add(Camera::create(CameraId::create(), $owner1, 'Camera 3'));
		Assert::count(2, $repository->belongingTo($owner1)->hydrate());
		Assert::count(1, $repository->belongingTo($owner2)->hydrate());
	}

}

(new InMemoryAllCamerasTest)->run();
