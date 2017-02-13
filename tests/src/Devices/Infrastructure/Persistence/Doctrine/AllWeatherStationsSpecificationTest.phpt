<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Authentication\DomainModel\{
	Owner\Owner, User\User, User\UserId
};
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	WeatherStation, WeatherStationId
};
use Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine\AllWeatherStationsSpecification;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class AllWeatherStationsSpecificationTest extends \Adeira\Connector\Tests\TestCase
{

	use \Testbench\TCompiledContainer;

	/**
	 * @var AllWeatherStationsSpecification
	 */
	private $specification;

	public function setUp()
	{
		$this->specification = new AllWeatherStationsSpecification(
			new Owner(new User(UserId::create(), 'username')),
			2, //limit
			WeatherStationId::create()
		);
	}

	public function testThatItIsPossibleToGetAllRequiredAttributes()
	{
		Assert::noError(function() {
			$qb = $this->getService(\Doctrine\ORM\EntityManagerInterface::class)->createQueryBuilder();
			$this->specification->match($qb, 'alias');
		});
	}

	public function testThatIsSatisfiedByReturnsTrue()
	{
		Assert::true($this->specification->isSatisfiedBy(WeatherStation::class));
	}

	public function testThatIsSatisfiedByReturnsFalse()
	{
		Assert::false($this->specification->isSatisfiedBy(\stdClass::class));
		Assert::false($this->specification->isSatisfiedBy('just a string'));
	}

}

(new AllWeatherStationsSpecificationTest)->run();
