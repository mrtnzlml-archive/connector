<?hh

namespace App\Presenters;

use Nette;

class HomepagePresenter extends Nette\Application\UI\Presenter
{

	public function renderDefault(): void
	{
		['a', 'b'] |> dump($$);
	}

}
