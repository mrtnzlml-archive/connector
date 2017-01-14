<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits;

interface ICalculator
{

	public function add($x, $increment);

	public function substract($x, $decrement);

}
