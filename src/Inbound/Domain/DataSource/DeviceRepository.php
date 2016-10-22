<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Domain\DataSource;

interface DeviceRepository
{

	public function nextIdentity();

}
