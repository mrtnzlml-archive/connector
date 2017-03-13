<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Camera;

use Adeira\Connector\Devices\Application\Service\Camera\Command\CreateCamera as CreateCameraCommand;
use Adeira\Connector\Devices\DomainModel\Camera\Camera;
use Adeira\Connector\Devices\DomainModel\Camera\CameraId;
use Adeira\Connector\Devices\DomainModel\Camera\IAllCameras;
use Adeira\Connector\GraphQL\Context;
use Adeira\Connector\ServiceBus\DomainModel\ICommandBus;

final class CreateCamera
{

	/**
	 * @var \Adeira\Connector\ServiceBus\DomainModel\ICommandBus
	 */
	private $commandBus;

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\Camera\IAllCameras
	 */
	private $allCameras;

	public function __construct(ICommandBus $commandBus, IAllCameras $allCameras)
	{
		$this->commandBus = $commandBus;
		$this->allCameras = $allCameras;
	}

	public function __invoke($ancestorValue, $args, Context $context): Camera
	{
		$newCameraId = CameraId::create();

		$this->commandBus->dispatch(
			new CreateCameraCommand(
				$args['streamSource'],
				$args['name'],
				$context->userId(),
				$newCameraId
			)
		);

		return $this->allCameras->withId($newCameraId);
	}

}
