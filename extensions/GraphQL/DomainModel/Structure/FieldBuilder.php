<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\DomainModel\Structure;

final class FieldBuilder
{

	private static $scalars = [
		'Int' => 'int',
		'Float' => 'float',
		'String' => 'string',
		'Boolean' => 'boolean',
		'ID' => 'id',
	];

	/**
	 * @param $fieldType array|string
	 */
	public static function resolveField($fieldType): FieldBuilderResponse
	{
		$listOf = FALSE;
		if (is_array($fieldType)) {
			$listOf = TRUE;
			$fieldType = $fieldType[0];
		}

		$nonNull = FALSE;
		$pattern = '~(.+)!$~';
		if (preg_match($pattern, $fieldType)) {
			$nonNull = TRUE;
			$fieldType = preg_replace($pattern, '$1', $fieldType);
		}

		if (array_key_exists($fieldType, self::$scalars)) {
			return new FieldBuilderResponse(TRUE, self::$scalars[$fieldType], $nonNull, $listOf);
		}
		return new FieldBuilderResponse(FALSE, $fieldType, $nonNull, $listOf);
	}

}
