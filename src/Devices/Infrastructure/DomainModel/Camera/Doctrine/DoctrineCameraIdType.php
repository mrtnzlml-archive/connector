<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\DomainModel\Camera\Doctrine;

use Adeira\Connector\Devices\DomainModel\Camera\CameraId;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class DoctrineCameraIdType extends \Adeira\Connector\Common\Infrastructure\DomainModel\DoctrineEntityId
{

	public function getTypeName(): string
	{
		return 'CameraId'; //(DC2Type:CameraId)
	}

	/**
	 * @param null|string $value
	 */
	public function convertToPHPValue($value, AbstractPlatform $platform): CameraId
	{
		$uuid = parent::convertToPHPValue($value, $platform);
		return CameraId::create($uuid);
	}

}
