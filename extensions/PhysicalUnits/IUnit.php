<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits;

interface IUnit
{

	public function __construct($value);

	public function value();

	public function getConversionTable(): array;

}
