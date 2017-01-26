<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Infrastructure\DomainModel\User\Doctrine;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class DoctrineUserIdType extends \Adeira\Connector\Common\Infrastructure\DomainModel\DoctrineEntityId
{

	public function getTypeName(): string
	{
		return 'UserId'; //(DC2Type:UserId)
	}

	public function convertToPHPValue($value, AbstractPlatform $platform): UserId
	{
		$uuid = parent::convertToPHPValue($value, $platform);
		return UserId::create($uuid);
	}

}
