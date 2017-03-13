<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\Infrastructure\Delivery\API\GraphQL\Camera;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Authentication\DomainModel\User\User;
use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\Application\Service\Camera\Command\CreateCamera as CreateCameraCommand;
use Adeira\Connector\Devices\DomainModel\Camera\Camera;
use Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Camera\CreateCamera;
use Adeira\Connector\Devices\Infrastructure\Persistence\InMemory\InMemoryAllCameras;
use Adeira\Connector\GraphQL\Context;
use Adeira\Connector\ServiceBus\Infrastructure\DomainModel\CommandBus;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class CreateCameraTest extends \Adeira\Connector\Tests\TestCase
{

	public function test_that_its_invokable()
	{
		$repository = new InMemoryAllCameras;
		$owner = new Owner(new User(UserId::create(), 'username'));

		// FIXME: toto netestuje proti skutečnosti (ale nejde vzít z DIC, protože schovává handler implementaci)
		$command = new CreateCamera(new CommandBus([
			CreateCameraCommand::class => function (CreateCameraCommand $aCommand) use (&$repository, $owner) {
				$repository->add(Camera::create(
					$aCommand->cameraId(),
					$owner,
					$aCommand->cameraName(),
					$aCommand->streamSource()
				));
			},
		]), $repository);

		$command(NULL, [ // __invoke
			'streamSource' => 'rtsp://a',
			'name' => 'Camera 1',
		], new Context(UserId::create()));
		Assert::count(1, $repository->belongingTo($owner)->hydrate());
		Assert::type(Camera::class, $repository->belongingTo($owner)->hydrateOne());
	}

}

(new CreateCameraTest)->run();