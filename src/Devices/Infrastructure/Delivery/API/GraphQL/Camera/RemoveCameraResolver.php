<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Camera;

use Adeira\Connector\Devices\Application\Service\Camera\Command\RemoveCamera;
use Adeira\Connector\Devices\Application\Service\Camera\Query\SingleCamera;
use Adeira\Connector\Devices\DomainModel\Camera\Camera;
use Adeira\Connector\Devices\DomainModel\Camera\CameraId;
use Adeira\Connector\GraphQL\Context;
use Adeira\Connector\ServiceBus\DomainModel\ICommandBus;

final class RemoveCameraResolver
{

	/**
	 * @var \Adeira\Connector\ServiceBus\DomainModel\ICommandBus
	 */
	private $commandBus;

	/**
	 * @var \Adeira\Connector\Devices\Application\Service\Camera\Query\SingleCamera
	 */
	private $singleCamera;

	public function __construct(ICommandBus $commandBus, SingleCamera $singleCamera)
	{
		$this->commandBus = $commandBus;
		$this->singleCamera = $singleCamera;
	}

	public function __invoke($ancestorValue, $args, Context $context): ?Camera
	{
		$cameraId = CameraId::createFromString($args['cameraId']);

		$originalCamera = $this->singleCamera->__invoke($context->userId(), $cameraId);

		$this->commandBus->dispatch(new RemoveCamera(
			$context->userId(),
			$cameraId
		));

		return $originalCamera;
	}

}
