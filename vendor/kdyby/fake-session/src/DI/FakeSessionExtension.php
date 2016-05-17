<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\FakeSession\DI;

use Kdyby;
use Nette;
use Nette\PhpGenerator as Code;



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class FakeSessionExtension extends Nette\DI\CompilerExtension
{

	/**
	 * @var array
	 */
	public $defaults = [
		'enabled' => '%consoleMode%',
	];



	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig($this->defaults);

		$original = $builder->getDefinition($originalServiceName = $builder->getByType('Nette\Http\Session') ?: 'session');
		$builder->removeDefinition($originalServiceName);
		$builder->addDefinition($this->prefix('original'), $original)
			->setAutowired(FALSE);

		$session = $builder->addDefinition($originalServiceName)
			->setClass('Nette\Http\Session')
			->setFactory('Kdyby\FakeSession\Session', [$this->prefix('@original')]);

		if ($config['enabled']) {
			$session->addSetup('disableNative');
		}
	}

}
