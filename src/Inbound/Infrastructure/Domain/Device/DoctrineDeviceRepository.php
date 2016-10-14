<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Infrastructure\Domain\Device;

use Adeira\Connector\Inbound;

class DoctrineDeviceRepository implements \Adeira\Connector\Inbound\Domain\Device\DeviceRepository
{

	public function nextIdentity()
	{
		return Inbound\Domain\Device\DeviceId::create();
	}

}
