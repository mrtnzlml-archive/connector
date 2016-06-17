<?hh

namespace App\Forms;

use Nette;
use Nette\Application\UI;
use Nette\Security\User;

class ContactFormFactory extends Nette\Object
{

	public function __construct(
		private FormFactory $factory,
		private User $user
 	) {}

	/**
	 * @return Form
	 */
	public function create((function (UI\Form, array): void) $onSuccess): UI\Form
	{
		$form = $this->factory->create();
		$form->addText('email')->setRequired();
		$form->addSubmit('Send');
		$form->onSuccess[] = function (UI\Form $form, $values) use ($onSuccess) {
			$onSuccess($form, $values);
		};
		return $form;
	}

}
