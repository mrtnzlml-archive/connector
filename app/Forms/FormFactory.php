<?hh

namespace App\Forms;

use Nette;
use Nette\Application\UI;

class FormFactory extends Nette\Object
{
	//use Nette\SmartObject;

	/**
	 * @return Form
	 */
	public function create(): UI\Form
	{
		return new UI\Form();
	}

}
