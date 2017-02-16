<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Infrastructure\DomainModel\Doctrine;

use Adeira\Connector\PhysicalUnits\Humidity\RelativeHumidity;
use Adeira\Connector\PhysicalUnits\Humidity\Units\Percentage;
use Adeira\Connector\PhysicalUnits\IPhysicalQuantity;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class DoctrineHumidityType extends \Doctrine\DBAL\Types\Type
{

	public function getName(): string
	{
		return 'Humidity'; //(DC2Type:Humidity)
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
		return new RelativeHumidity(new Percentage($value));
	}

	/**
	 * This is executed when the value is written to the database. Make your conversions here, optionally using the $platform.
	 */
	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		if ($value instanceof IPhysicalQuantity) {
			return $value->convertTo(Percentage::class)->value();
		}
		return NULL;
	}

}
