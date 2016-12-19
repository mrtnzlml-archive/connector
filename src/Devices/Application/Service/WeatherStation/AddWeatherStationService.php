<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\Owner\IOwnerService;
use Adeira\Connector\Common\Application\Service\ITransactionalSession;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IWeatherStationRepository,
	WeatherStation
};

/**
 * Application services should depend on abstraction (interfaces) so we'll make our Application Service immune to
 * low-level Infrastructure changes. It's important to keep your Application Services setup out of the Infrastructure
 * boundary. Also those services should be registered in DIC.
 */
class AddWeatherStationService
{

	use \Nette\SmartObject;

	/**
	 * @var IWeatherStationRepository
	 */
	private $weatherStationRepository;

	/**
	 * @var \Adeira\Connector\Common\Application\Service\ITransactionalSession
	 */
	private $transactionalSession;

	/**
	 * @var \Adeira\Connector\Authentication\DomainModel\Owner\IOwnerService
	 */
	private $ownerService;

	public function __construct(
		IWeatherStationRepository $weatherStationRepository,
		ITransactionalSession $transactionalSession,
		IOwnerService $ownerService
	) {
		$this->weatherStationRepository = $weatherStationRepository;
		$this->transactionalSession = $transactionalSession;
		$this->ownerService = $ownerService;
	}

	/**
	 * AddWeatherStationRequest should be simple DTO filled by form in presenter.
	 *
	 * @throws \Adeira\Connector\Authentication\Application\Exception\InvalidOwnerException
	 */
	public function execute(AddWeatherStationRequest $request): AddWeatherStationResponse
	{
		$owner = $this->ownerService->ownerFrom($request->userId());
		if ($owner === NULL) {
			throw new \Adeira\Connector\Authentication\Application\Exception\InvalidOwnerException($owner);
		}

		return $this->transactionalSession->executeAtomically(function () use ($request, $owner) {
			$this->weatherStationRepository->add($weatherStation = new WeatherStation(
				$this->weatherStationRepository->nextIdentity(),
				$owner,
				$request->name()
			));

			//instead of manual DTO creation it's better to use DTO assembler:
			//return $this->weatherStationDtoAssembler->assemble($weatherStation);
			return new AddWeatherStationResponse($weatherStation->id()); // it's returned to the controller!
		});
	}

}
