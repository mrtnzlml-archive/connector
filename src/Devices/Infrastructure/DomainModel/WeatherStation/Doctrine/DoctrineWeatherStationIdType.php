<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\DomainModel\WeatherStation\Doctrine;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class DoctrineWeatherStationIdType extends \Adeira\Connector\Common\Infrastructure\DomainModel\DoctrineEntityId
{

	public function getTypeName(): string
	{
		return 'WeatherStationId'; //(DC2Type:WeatherStationId)
	}

	/**
	 * @param null|string $value
	 */
	public function convertToPHPValue($value, AbstractPlatform $platform): WeatherStationId
	{
		$uuid = parent::convertToPHPValue($value, $platform);
		return WeatherStationId::create($uuid);
	}

}
