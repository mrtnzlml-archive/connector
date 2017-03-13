<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Camera;

use Adeira\Connector\Devices\Application\Service\Camera\Query\ViewAllCameras;
use Adeira\Connector\GraphQL\Context;

final class AllCamerasResolver
{

	/**
	 * @var \Adeira\Connector\Devices\Application\Service\Camera\Query\ViewAllCameras
	 */
	private $allCameras;

	public function __construct(ViewAllCameras $allCameras)
	{
		$this->allCameras = $allCameras;
	}

	/**
	 * @return \Adeira\Connector\Devices\DomainModel\Camera\Camera[]
	 */
	public function __invoke($ancestor, array $args, Context $context): array
	{
		return $this->allCameras->execute($context->userId());
	}

}
