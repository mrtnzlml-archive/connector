<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\Application\Service\Camera\Query;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Authentication\DomainModel\User\User;
use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Authentication\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use Adeira\Connector\Devices\Application\Service\Camera\Query\SingleCamera;
use Adeira\Connector\Devices\DomainModel\Camera\Camera;
use Adeira\Connector\Devices\DomainModel\Camera\CameraId;
use Adeira\Connector\Devices\Infrastructure\Persistence\InMemory\InMemoryAllCameras;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class SingleCameraTest extends \Adeira\Connector\Tests\TestCase
{

	public function test_that_invoke_works()
	{
		$userId = UserId::create();
		$userRepository = new InMemoryUserRepository;
		$userRepository->add(new User($userId, 'username'));
		$ownerService = new UserIdOwnerService($userRepository);

		$camerasRepository = new InMemoryAllCameras;
		$camerasRepository->add(Camera::create(
			$cameraId = CameraId::create(),
			new Owner(new User($userId, 'username')),
			'Camera 1',
			'rtsp://stream.source'
		));

		$query = new SingleCamera($camerasRepository, $ownerService);
		Assert::type(Camera::class, $query($userId, $cameraId)); // __invoke
	}

	public function test_that_null_invoke_works()
	{
		$userId = UserId::create();
		$userRepository = new InMemoryUserRepository;
		$userRepository->add(new User($userId, 'username'));
		$ownerService = new UserIdOwnerService($userRepository);
		$query = new SingleCamera(new InMemoryAllCameras, $ownerService);
		Assert::null($query($userId, CameraId::create())); // __invoke
	}

}

(new SingleCameraTest)->run();
