<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Inbound\DomainModel\DataSource;

use Adeira\Connector\Inbound\DomainModel\DataSource\DataSourceId;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
class DataSourceIdTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatConstructorIsPrivate()
	{
		Assert::exception(function () {
			new DataSourceId;
		}, \Error::class, 'Call to private ' . DataSourceId::class . '::__construct() from context%a%');
	}

	public function testValuesAreEqual()
	{
		$id1 = DataSourceId::create('id');
		$id2 = DataSourceId::create('id');
		Assert::notSame($id1, $id2);
		Assert::true($id1->equals($id2));
		Assert::true($id2->equals($id1));
	}

}

(new DataSourceIdTest)->run();
