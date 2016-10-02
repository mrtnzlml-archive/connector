<?php declare(strict_types = 1);

namespace App\Latte\DI;

class Extension extends \Adeira\CompilerExtension
{

	public function loadConfiguration()
	{
		$this->addConfig(__DIR__ . '/config.neon');
	}

}
