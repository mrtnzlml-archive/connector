<?php declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI;

class FormFactory
{

	use Nette\SmartObject;

	public function create(): UI\Form
	{
		return new UI\Form();
	}

}
