<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Application\Service;

use Nette\Utils\Json;

/**
 * AddDataSourceRequest is just simple DTO and should be filled by form in presenter.
 *  - use primitives
 *  - make it serializable
 *  - no business logic
 *  - no tests
 */
class AddDataSourceRecordRequest
{

	/**
	 * @var string
	 */
	private $dataSourceId;

	/**
	 * @var array
	 */
	private $data;

	public function __construct(string $dataSourceId, string $jsonData)
	{
		$this->dataSourceId = $dataSourceId;
		$this->data = Json::decode($jsonData, Json::FORCE_ARRAY);
	}

	public function dataSourceId(): string
	{
		return $this->dataSourceId;
	}

	public function data(): array
	{
		return $this->data;
	}

}
