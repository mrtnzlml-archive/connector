<?hh

namespace App\Presenters;

use Nette;
use Nette\Application\UI;

class WebcomponentsPresenter extends Nette\Application\UI\Presenter
{

	//FIXME: nemělo by být přístupné z webu mimo Polymer (?)

	public function __construct(private \App\Forms\ContactFormFactory $factory) {}

	public function createComponentContactForm(): UI\Form {
		return $this->factory->create(function(UI\Form $form, $values) {
			$this->flashMessage(json_encode($values));
			$this->redirect('Homepage:default'); //FIXME: přesměruje na WebcomponentPresenter - ale chci na místo kde je komponenta použita
		});
	}

}
