<?hh

namespace App\Presenters;

use Nette;
use Nette\Application\UI;

class WebcomponentsPresenter extends Nette\Application\UI\Presenter
{

	//FIXME: nemělo by být přístupné z webu mimo Polymer (?)

	public function __construct(private \App\Forms\ContactFormFactory $factory) {
		parent::__construct();
	}

	public function createComponentContactForm(): UI\Form
	{
		return $this->factory->create(function(UI\Form $form, Nette\Utils\ArrayHash $values) {
			dump($values->email);
			dump($values);exit;
			$this->flashMessage(json_encode($values));
			$this->redirect('Homepage:default'); //FIXME: přesměruje na WebcomponentPresenter - ale chci na místo kde je komponenta použita
		});
	}

}
