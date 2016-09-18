<?php

namespace App\Components;

class FlashMessage extends Webcomponent
{

	public function render()
	{
		$flashes = [];
		if ($this->presenter->hasFlashSession()) {
			$id = $this->presenter->getParameterId('flash');
			$flashes = (array)$this->presenter->getFlashSession()->$id;
		}
		$this->template->flashes = $flashes;
		$this->template->render(__DIR__ . '/FlashMessage.latte');
	}

}
