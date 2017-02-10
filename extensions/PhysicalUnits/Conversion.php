<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits;

final class Conversion
{

	public function convert(IPhysicalQuantity $fromPhysicalQuantity, string $toUnit): IPhysicalQuantity
	{
		$fromUnit = $fromPhysicalQuantity->unit();
		$conversionTable = $fromUnit->getConversionTable();

		if (get_class($fromUnit) === $toUnit) {
			return new $fromPhysicalQuantity($fromUnit); // without conversion
		}

		if (!array_key_exists($toUnit, $conversionTable)) {
			$short = function ($classWithNamespace) {
				$class = is_object($classWithNamespace) ? get_class($classWithNamespace) : $classWithNamespace;
				$occurrence = strrchr($class, '\\');
				return $occurrence ? substr($occurrence, 1) : $class;
			};
			throw new \OutOfBoundsException("Cannot convert '" . $short($fromUnit) . "' -> '" . $short($toUnit) . "' because conversion is unknown.");
		}

		$callback = $conversionTable[$toUnit];
		return new $fromPhysicalQuantity($callback($fromUnit));
	}

}
