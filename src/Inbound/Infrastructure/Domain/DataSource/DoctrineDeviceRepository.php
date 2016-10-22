<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Infrastructure\Domain\DataSource;

use Adeira\Connector\Inbound;

class DoctrineDeviceRepository implements \Adeira\Connector\Inbound\Domain\DataSource\DeviceRepository
{

	public function nextIdentity()
	{
		return Inbound\Domain\DataSource\DeviceId::create();
	}

}
