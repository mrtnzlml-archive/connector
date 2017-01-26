<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationRecord;
use Adeira\Connector\GraphQL\Structure\{
	FieldSpecification, TypeSpecification
};
use GraphQL\Type\Definition;

final class WeatherStationRecordType extends Definition\ObjectType
{

	public function __construct()
	{
		$wsrType = new TypeSpecification('WeatherStationRecord', 'Record of the weather station');
		$idField = new FieldSpecification('id', 'ID of the weather station record', new Definition\NonNull(
			Definition\Type::string()
		));
		$idField->setResolveFunction(function (WeatherStationRecord $wsr, $args, UserId $userId) {
			return $wsr->id();
		});
		$wsrType->addField($idField);

		parent::__construct($wsrType->buildArray());
	}

}
