<?php declare(strict_types = 1);

namespace Adeira\Connector\Presenters;

use Nette;

class ApiErrorPresenter extends \Adeira\Api\RestPresenter
{

	public function run(Nette\Application\Request $request): Nette\Application\IResponse
	{
		$this->payload = new \stdClass;
		$this->payload->error = [
			'message' => 'Internal Server Error',
		];
		$this->payload->status = 'error';
		return new \Adeira\Api\JsonResponsePretty($this->payload);
	}

}
