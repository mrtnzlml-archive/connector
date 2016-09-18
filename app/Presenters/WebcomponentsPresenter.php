<?php declare(strict_types = 1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI;

class WebcomponentsPresenter extends Nette\Application\UI\Presenter
{

	//FIXME: nemělo by být přístupné z webu mimo Polymer (?)

	private $factory;

	public function __construct(\App\Forms\ContactFormFactory $factory)
	{
		parent::__construct();
		$this->factory = $factory;
	}

	public function createComponentContactForm(): UI\Form
	{
		return $this->factory->create(function (UI\Form $form, Nette\Utils\ArrayHash $values) {
			$this->flashMessage(json_encode($values));
			$this->redirect('Homepage:default');
		});
	}

}
