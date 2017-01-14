<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits;

interface IUnit
{

	public function unitCode(): string;

	public function getConversionTable(): array;

}
