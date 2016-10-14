<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Domain\Device;

class DeviceId
{

	use \Nette\SmartObject;

	private $id;

	private function __construct($anId = NULL)
	{
		$this->id = $anId ?: \Ramsey\Uuid\Uuid::uuid4()->toString();
	}

	public static function create($anId = NULL)
	{
		return new static($anId);
	}

}
