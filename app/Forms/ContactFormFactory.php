<?php declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI;
use Nette\Security\User;

class ContactFormFactory
{

	use Nette\SmartObject;

	private $factory;

	private $user;

	public function __construct(FormFactory $factory, User $user)
	{
		$this->factory = $factory;
		$this->user = $user;
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
