<?php

namespace App\Components;

trait TFlashMessage
{

	/** @var FlashMessage */
	private $flashMessage;

	public function injectFlashMessage(FlashMessage $flashMessage)
	{
		$this->flashMessage = $flashMessage;
	}

	protected function createComponentFlashMessage()
	{
		return $this->flashMessage;
	}

}
