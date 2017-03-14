<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Camera;

use Adeira\Connector\Devices\DomainModel\Camera\Camera;

final class CameraResolver
{

	public function id(Camera $camera): string
	{
		return $camera->id()->toString();
	}

}
