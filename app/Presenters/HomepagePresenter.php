<?php declare(strict_types = 1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI;

class HomepagePresenter extends UI\Presenter
{

	use \App\Components\TFlashMessage;

	public function __construct(\App\PostgreJSON\DML\Select $select)
	{
		parent::__construct();

		$select->text();
	}

}
