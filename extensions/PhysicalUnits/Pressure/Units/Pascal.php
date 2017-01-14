<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Pressure\Units;

use Adeira\Connector\PhysicalUnits\Pressure\IPressureUnit;

class Pascal implements IPressureUnit
{

	public function unitCode(): string
	{
		return 'Pa';
	}

}
