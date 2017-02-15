<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\DomainModel\WeatherStation\Doctrine;

use Adeira\Connector\PhysicalUnits\IPhysicalQuantity;
use Adeira\Connector\PhysicalUnits\Pressure\Pressure;
use Adeira\Connector\PhysicalUnits\Pressure\Units\Pascal;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class DoctrinePressureType extends \Doctrine\DBAL\Types\Type
{

	public function getName(): string
	{
		return 'Pressure'; //(DC2Type:Pressure)
	}

	/**
	 * Return the SQL used to create your column type. To create a portable column type, use the $platform.
	 */
	public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
	{
		return $platform->getFloatDeclarationSQL($fieldDeclaration);
	}

	/**
	 * This is executed when the value is read from the database. Make your conversions here, optionally using the $platform.
	 */
	public function convertToPHPValue($value, AbstractPlatform $platform)
	{
		return new Pressure(new Pascal($value));
	}

	/**
	 * This is executed when the value is written to the database. Make your conversions here, optionally using the $platform.
	 */
	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		if ($value instanceof IPhysicalQuantity) {
			return $value->convertTo(Pascal::class)->value();
		}
		return NULL;
	}

}
