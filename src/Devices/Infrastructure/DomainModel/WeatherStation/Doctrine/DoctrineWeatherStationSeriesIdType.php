<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\DomainModel\WeatherStation\Doctrine;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationSeriesId;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class DoctrineWeatherStationSeriesIdType extends \Adeira\Connector\Common\Infrastructure\DomainModel\DoctrineEntityId
{

	public function getTypeName(): string
	{
		return 'WeatherStationSeriesId'; //(DC2Type:WeatherStationSeriesId)
	}

	/**
	 * @param null|string $value
	 */
	public function convertToPHPValue($value, AbstractPlatform $platform): WeatherStationSeriesId
	{
		$uuid = parent::convertToPHPValue($value, $platform);
		return WeatherStationSeriesId::create($uuid);
	}

}
