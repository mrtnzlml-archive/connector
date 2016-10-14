<?php declare(strict_types = 1);

namespace Adeira\Connector\Forms;

use Nette\Application\UI;

class FormFactory
{

	use \Nette\SmartObject;

	public function create(): UI\Form
	{
		return new UI\Form();
	}

}
