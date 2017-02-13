<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\Application\Service\WeatherStation\Command;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Authentication\DomainModel\User\User;
use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Authentication\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use Adeira\Connector\Devices\Application\Service\WeatherStation\Command\CreateWeatherStation;
use Adeira\Connector\Devices\Application\Service\WeatherStation\Command\CreateWeatherStationHandler;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStation;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;
use Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine\InMemoryWeatherStationRepository;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class CreateWeatherStationHandlerTest extends \Adeira\Connector\Tests\TestCase
{

	/** @var CreateWeatherStationHandler */
	private $handler;

	/** @var InMemoryWeatherStationRepository */
	private $weatherStationRespository;

	public function setUp()
	{
		$userRepository = new InMemoryUserRepository;
		$userRepository->add(new User(UserId::createFromString('00000000-0000-0000-0000-555500004444'), 'User Name'));
		$this->handler = new CreateWeatherStationHandler(
			$this->weatherStationRespository = new InMemoryWeatherStationRepository(WeatherStationId::createFromString('11111111-2222-3333-4444-555555555555')),
			new UserIdOwnerService($userRepository)
		);
	}

	public function testThatHandlerWorks()
	{
		$userId = UserId::createFromString('00000000-0000-0000-0000-555500004444');
		$handler = $this->handler;
		$handler(new CreateWeatherStation('Weather Station Name', $userId));
		Assert::type(
			WeatherStation::class,
			$this->weatherStationRespository->ofId(WeatherStationId::createFromString('11111111-2222-3333-4444-555555555555'), new Owner(new User($userId, 'username')))
		);
	}

	public function testThathandlerThrowsExceptionForUnauthorizedUser()
	{
		$handler = $this->handler;
		Assert::exception(
			function () use ($handler) {
				$handler(new CreateWeatherStation('Weather Station Name', UserId::create()));
			},
			\Adeira\Connector\Authentication\Application\Exception\InvalidOwnerException::class,
			'Owner is not valid or it doesn\'t have enough permissions.'
		);
	}

}

(new CreateWeatherStationHandlerTest)->run();
