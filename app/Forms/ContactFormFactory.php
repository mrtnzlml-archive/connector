<?php declare(strict_types = 1);

namespace Adeira\Connector\Forms;

use Nette\Application\UI;

class ContactFormFactory
{

	use \Nette\SmartObject;

	private $factory;

	public function __construct(FormFactory $factory)
	{
		$this->factory = $factory;
	}

	public function create(\Closure $onSuccess): UI\Form
	{
		$form = $this->factory->create();
		$form->addText('email');//->setRequired();
		$form->addSubmit('send');
		$form->onSuccess[] = function (UI\Form $form, $values) use ($onSuccess) {
			$onSuccess($form, $values);
		};
		return $form;
	}

}
