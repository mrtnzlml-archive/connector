<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Application\Service;

use Adeira\Connector\Authentication\DomainModel\User\UserId;

/**
 * AddDataSourceRequest is just simple DTO and should be filled by form in presenter.
 *  - use primitives
 *  - make it serializable
 *  - no business logic
 *  - no tests
 */
class AddDataSourceRequest
{

	use \Nette\SmartObject;

	private $dataSourceName;

	private $userId;

	public function __construct(string $dataSourceName, UserId $userId)
	{
		$this->dataSourceName = $dataSourceName;
		$this->userId = $userId;
	}

	public function name(): string
	{
		return $this->dataSourceName;
	}

	public function userId(): UserId
	{
		return $this->userId;
	}

}
