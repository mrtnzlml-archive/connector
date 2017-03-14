<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\Application\Service\Camera\Query;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Authentication\DomainModel\User\User;
use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Authentication\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use Adeira\Connector\Devices\Application\Service\Camera\Command\RemoveCamera;
use Adeira\Connector\Devices\Application\Service\Camera\Command\RemoveCameraHandler;
use Adeira\Connector\Devices\DomainModel\Camera\Camera;
use Adeira\Connector\Devices\DomainModel\Camera\CameraId;
use Adeira\Connector\Devices\DomainModel\Camera\Stream;
use Adeira\Connector\Devices\DomainModel\Camera\StreamService;
use Adeira\Connector\Devices\Infrastructure\Persistence\InMemory\InMemoryAllCameras;
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class RemoveCameraHandlerTest extends \Adeira\Connector\Tests\TestCase
{

	public function test_that_invoke_works()
	{
		//OMG, maybe it's time to use Mockery...

		$userId = UserId::create();
		$user = new User($userId, 'username');
		$userRepository = new InMemoryUserRepository;
		$userRepository->add($user);
		$ownerService = new UserIdOwnerService($userRepository);
		$cameraId = CameraId::create();
		$owner = new Owner($user);
		$allCamerasRepository = new InMemoryAllCameras;
		$allCamerasRepository->add(Camera::create($cameraId, $owner, 'Camera 1', new Stream('rtsp://stream.source', Uuid::uuid4())));
		$httpClient = \Mockery::mock(\GuzzleHttp\ClientInterface::class);
		$httpClient->shouldReceive('request')->once();
		$streamService = new StreamService($httpClient);
		$queryHandler = new RemoveCameraHandler($ownerService, $allCamerasRepository, $streamService);
		$removeCommand = new RemoveCamera($userId, $cameraId);

		Assert::count(1, $allCamerasRepository->belongingTo($owner)->hydrate());
		$queryHandler($removeCommand);
		Assert::count(0, $allCamerasRepository->belongingTo($owner)->hydrate());
	}

	public function test_that_removing_non_existent_camera_works()
	{
		$userId = UserId::create();
		$user = new User($userId, 'username');
		$userRepository = new InMemoryUserRepository;
		$userRepository->add($user);
		$ownerService = new UserIdOwnerService($userRepository);
		$allCamerasRepository = new InMemoryAllCameras;
		$httpClient = \Mockery::mock(\GuzzleHttp\ClientInterface::class);
		$streamService = new StreamService($httpClient);
		$queryHandler = new RemoveCameraHandler($ownerService, $allCamerasRepository, $streamService);
		$cameraId = CameraId::create();
		$removeCommand = new RemoveCamera($userId, $cameraId);

		Assert::noError(function () use ($queryHandler, $removeCommand) {
			$queryHandler($removeCommand);
		});
	}

	public function tearDown()
	{
		\Mockery::close();
	}

}

(new RemoveCameraHandlerTest)->run();
