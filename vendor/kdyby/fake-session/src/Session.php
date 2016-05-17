<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.md that was distributed with this source code.
 */

namespace Kdyby\FakeSession;

use Kdyby;
use Nette;
use Nette\Http\ISessionStorage;



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class Session extends Nette\Http\Session
{

	/**
	 * @var array|SessionSection[]
	 */
	private $sections = [];

	/**
	 * @var bool
	 */
	private $started = FALSE;

	/**
	 * @var bool
	 */
	private $exists = FALSE;

	/**
	 * @var string
	 */
	private $id = NULL;

	/**
	 * @var Nette\Http\Session
	 */
	private $originalSession;

	/**
	 * @var bool
	 */
	private $fakeMode = FALSE;



	public function __construct(Nette\Http\Session $originalSession)
	{
		$this->originalSession = $originalSession;
	}



	public function disableNative()
	{
		if ($this->originalSession->isStarted()) {
			throw new \LogicException('Session is already started, please close it first and then you can disabled it.');
		}

		$this->fakeMode = TRUE;
	}



	public function enableNative()
	{
		$this->fakeMode = FALSE;
	}



	/**
	 * @return boolean
	 */
	public function isNativeEnabled()
	{
		return ! $this->fakeMode;
	}



	public function start()
	{
		if (!$this->fakeMode) {
			$this->originalSession->start();
		}
	}



	public function isStarted()
	{
		if (!$this->fakeMode) {
			return $this->originalSession->isStarted();
		}

		return $this->started;
	}



	/**
	 * @param bool $started
	 */
	public function setFakeStarted($started)
	{
		$this->started = $started;
	}



	public function close()
	{
		if (!$this->fakeMode) {
			$this->originalSession->close();
		}
	}



	public function destroy()
	{
		if (!$this->fakeMode) {
			$this->originalSession->destroy();
		}
	}



	public function exists()
	{
		if (!$this->fakeMode) {
			return $this->originalSession->exists();
		}

		return $this->exists;
	}



	/**
	 * @param boolean $exists
	 * @return Session
	 */
	public function setFakeExists($exists)
	{
		$this->exists = $exists;
	}



	public function regenerateId()
	{
		if (!$this->fakeMode) {
			$this->originalSession->regenerateId();
		}
	}



	public function getId()
	{
		if (!$this->fakeMode) {
			return $this->originalSession->getId();
		}

		return $this->id;
	}



	/**
	 * @param string $id
	 * @return Session
	 */
	public function setFakeId($id)
	{
		$this->id = $id;
	}



	public function getSection($section, $class = 'Nette\Http\SessionSection')
	{
		if (!$this->fakeMode) {
			return $this->originalSession->getSection($section, $class);
		}

		if (isset($this->sections[$section])) {
			return $this->sections[$section];
		}

		return $this->sections[$section] = parent::getSection($section, $class !== 'Nette\Http\SessionSection' ? $class : 'Kdyby\FakeSession\SessionSection');
	}



	public function hasSection($section)
	{
		if (!$this->fakeMode) {
			return $this->originalSession->hasSection($section);
		}

		return isset($this->sections[$section]);
	}



	public function getIterator()
	{
		if (!$this->fakeMode) {
			return $this->originalSession->getIterator();
		}

		return new \ArrayIterator(array_keys($this->sections));
	}



	public function clean()
	{
		if (!$this->fakeMode) {
			$this->originalSession->clean();
		}
	}



	public function setName($name)
	{
		return $this->originalSession->setName($name);
	}



	public function getName()
	{
		return $this->originalSession->getName();
	}



	public function setOptions(array $options)
	{
		return $this->originalSession->setOptions($options);
	}



	public function getOptions()
	{
		return $this->originalSession->getOptions();
	}



	public function setExpiration($time)
	{
		return $this->originalSession->setExpiration($time);
	}



	public function setCookieParameters($path, $domain = NULL, $secure = NULL)
	{
		return $this->originalSession->setCookieParameters($path, $domain, $secure);
	}



	public function getCookieParameters()
	{
		return $this->originalSession->getCookieParameters();
	}



	public function setSavePath($path)
	{
		return $this->originalSession->setSavePath($path);
	}



	public function setStorage(ISessionStorage $storage)
	{
		return $this->originalSession->setStorage($storage);
	}



	public function setHandler(\SessionHandlerInterface $handler)
	{
		return $this->originalSession->setHandler($handler);
	}

}
