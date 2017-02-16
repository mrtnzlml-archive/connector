<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits;

interface IPhysicalQuantity
{

	public function value(): float;

	public function unit(): IUnit;

	public function convertTo(string $toUnit): IPhysicalQuantity;

}
