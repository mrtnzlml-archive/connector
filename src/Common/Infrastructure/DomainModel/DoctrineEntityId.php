<?php declare(strict_types = 1);

namespace Adeira\Connector\Common\Infrastructure\DomainModel;

abstract class DoctrineEntityId extends \Ramsey\Uuid\Doctrine\UuidType
{

	public function getName(): string
	{
		return $this->getTypeName(); //(DC2Type:CustomTypeId)
	}

	abstract public function getTypeName(): string;

}
