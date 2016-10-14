<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Domain\Device;

interface DeviceRepository
{

	public function nextIdentity();

}
