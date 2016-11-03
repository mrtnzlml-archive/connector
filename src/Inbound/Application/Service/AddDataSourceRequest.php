<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Application\Service;

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

	public function __construct(string $dataSourceName)
	{
		$this->dataSourceName = $dataSourceName;
	}

	public function name(): string
	{
		return $this->dataSourceName;
	}

}
