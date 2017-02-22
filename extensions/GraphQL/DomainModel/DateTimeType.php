<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\DomainModel;

final class DateTimeType extends \GraphQL\Type\Definition\ScalarType
{

	/**
	 * ISO8601 does not support microseconds even though Javascript generates it.
	 * @see https://bugs.php.net/bug.php?id=51950
	 */
	private const JS_ATOM = 'Y-m-d\TH:i:s.uP';

	public $name = 'DateTime';

	public $description = 'The `DateTime` scalar type represents date/time format compatible with ISO 8601 format.';

	/**
	 * Called when converting internal representation of value returned by your app (e.g. stored in database or hardcoded in source code) to serialized
	 * representation included in response.
	 */
	public function serialize($value): string
	{
		if (!$value instanceof \DateTimeInterface) {
			throw new \UnexpectedValueException("Cannot represent value as {$this->name}: " . \GraphQL\Utils::printSafe($value));
		}
		return $value->format('c');
	}

	/**
	 * Called when converting input value passed by client in variables along with GraphQL query to internal representation of your app.
	 */
	public function parseValue($value): \DateTimeInterface
	{
		//NOTE: DATE_ISO8601 format is not compatible with ISO-8601, but is left this way in PHP for backward compatibility reasons.
		//  http://php.net/manual/en/class.datetime.php#datetime.constants.types
		$dateTime = \DateTimeImmutable::createFromFormat(\DateTime::ATOM, $value);
		if ($dateTime === FALSE) { // compatibility with Javascript
			$dateTime = \DateTimeImmutable::createFromFormat(self::JS_ATOM, $value);
		}
		if ($dateTime === FALSE) {
			throw new \UnexpectedValueException('Not a valid ISO 8601 date format.');
		}
		return $dateTime;
	}

	/**
	 * Called when converting input literal value hardcoded in GraphQL query (e.g. field argument value) to internal representation of your app.
	 *
	 * E.g.: { someQuery(dateTime: "Tue Feb 21 2017 17:31:44 GMT+0100 (CET)") }
	 *
	 * @param \GraphQL\Language\AST\Node $valueNode
	 */
	public function parseLiteral($valueNode): \DateTimeInterface
	{
		// Note: throwing GraphQL\Error\Error vs \UnexpectedValueException to benefit from GraphQL
		// error location in query:
		if (!$valueNode instanceof \GraphQL\Language\AST\StringValueNode) {
			throw new \GraphQL\Error\Error('Query error: Can only parse strings got: ' . $valueNode->kind, [$valueNode]);
		}

		return $this->parseValue($valueNode->value);
	}

}
