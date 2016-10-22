<?php declare(strict_types = 1);

namespace Adeira\Connector\Common;

class UuidProvider
{

	public static function provide(): \Ramsey\Uuid\UuidInterface
	{
		return \Ramsey\Uuid\Uuid::uuid4();
	}

}
