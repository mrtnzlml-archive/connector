<?php

namespace App\Components;

use Latte\Loaders\StringLoader;

class Webcomponent extends \Nette\Application\UI\Control
{

	protected function createComponentPolyfile()
	{
		return new class extends \Nette\Application\UI\Control
		{
			private $polyfiles = [];

			public function render()
			{
				/** @var \Latte\Engine $latte */
				$latte = $this->template->getLatte();
				$latte->setLoader(new StringLoader);
				$polyfiles = '';
				foreach ($this->polyfiles as $file) {
					$polyfiles .= "<link rel=\"import\" href=\"{\$basePath}/components/$file\">\n";
				}
				$latte->render($polyfiles, [
					'basePath' => $this->template->basePath
				]);
			}

			public function addPolyfile(string $polyfile)
			{
				$this->polyfiles[] = $polyfile;
				$this->polyfiles = array_unique($this->polyfiles);
			}
		};
	}

}
