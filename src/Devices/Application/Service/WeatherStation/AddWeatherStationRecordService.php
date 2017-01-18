<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Common\Application\Service\ITransactionalSession;
use Adeira\Connector\Devices\DomainModel\Pressure;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IWeatherStationRecordRepository,
	IWeatherStationRepository,
	WeatherStation,
	WeatherStationId,
	WeatherStationRecord
};
use Adeira\Connector\PhysicalUnits\Pressure\Units\Pascal;

/**
 * Application services should depend on abstraction (interfaces) so we'll make our Application Service immune to
 * low-level Infrastructure changes. It's important to keep your Application Services setup out of the Infrastructure
 * boundary. Also those services should be registered in DIC.
 */
class AddWeatherStationRecordService
{

	/**
	 * @var IWeatherStationRepository
	 */
	private $weatherStationRepository;

	/**
	 * @var IWeatherStationRecordRepository
	 */
	private $weatherStationRecordRepository;

	/**
	 * @var \Adeira\Connector\Common\Application\Service\ITransactionalSession
	 */
	private $transactionalSession;

	public function __construct(
		IWeatherStationRepository $weatherStationRepository,
		IWeatherStationRecordRepository $weatherStationRecordRepository,
		ITransactionalSession $transactionalSession
	) {
		$this->weatherStationRepository = $weatherStationRepository;
		$this->weatherStationRecordRepository = $weatherStationRecordRepository;
		$this->transactionalSession = $transactionalSession;
	}

	/**
	 * AddWeatherStationRequest should be simple DTO filled by form in presenter.
	 */
	public function execute(AddWeatherStationRecordRequest $request): bool
	{
		return $this->transactionalSession->executeAtomically(function () use ($request) {
			$weatherStation = $this->findWeatherStationOrFail(
				$request->weatherStationId()
			);

			$this->weatherStationRecordRepository->add(new WeatherStationRecord(
				$this->weatherStationRecordRepository->nextIdentity(),
				$weatherStation->id(),
				new Pressure(new Pascal($request->pressure()))
			));

			return TRUE; //TODO
		});
	}

	private function findWeatherStationOrFail(string $weatherStationId): WeatherStation
	{
		$weatherStation = $this->weatherStationRepository->ofId(
			$weatherStationId = WeatherStationId::createFromString($weatherStationId)
		);
		if ($weatherStation === NULL) {
			throw new \Adeira\Connector\Devices\Application\Exceptions\WeatherStation\WeatherStationDoesNotExistException($weatherStationId);
		}
		return $weatherStation;
	}

}
