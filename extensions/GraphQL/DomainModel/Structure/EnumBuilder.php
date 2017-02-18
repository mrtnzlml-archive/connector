<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\DomainModel\Structure;

final class EnumBuilder
{

	public static function buildEnumArrayStructure(string $enumName, array $enumDetails): array
	{
		return [
			'config' => [
				'name' => $enumName,
				'values' => EnumBuilder::buildEnumValues($enumDetails),
			],
		];
	}

	public static function buildEnumValues(array $enumDetails): array
	{
		$output = [];
		foreach ($enumDetails as $enumName => $enumDetail) {
			$output[$enumName] = [
				'value' => $enumDetail,
			];
		}
		return $output;
	}

}
