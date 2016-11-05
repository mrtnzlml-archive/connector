<?php declare(strict_types = 1);

use Tester\Dumper;
use Tester\Runner\Runner;

/** @var \Tester\Runner\Runner $runner */
$runner->outputHandlers = []; // delete native output handlers
$runner->outputHandlers[] = new class ($runner) extends \Tester\Runner\Output\ConsolePrinter
{

	public function begin()
	{
		ob_start();
		parent::begin();
		echo rtrim(ob_get_clean()) . ' | ' . getenv('BOOTSTRAP') . "\n\n";
	}

	public function result($testName, $result, $message)
	{
		$outputs = [
			Runner::PASSED => Dumper::color('green', '✔ ' . $testName),
			Runner::SKIPPED => Dumper::color('olive', 's ' . $testName) . "($message)",
			Runner::FAILED => Dumper::color('red', '✖ ' . $testName) . "\n" . $this->indent($message, 3) . "\n",
		];
		echo $this->indent($outputs[$result], 2) . PHP_EOL;
	}

	public function end()
	{
		ob_start();
		parent::end();
		echo "\n" . trim(ob_get_clean()) . "\n";
	}

	private function indent($message, $spaces)
	{
		if ($message) {
			$result = '';
			foreach (explode(PHP_EOL, $message) as $line) {
				$result .= str_repeat(' ', $spaces) . $line . PHP_EOL;
			}
			return rtrim($result, PHP_EOL);
		}
		return $message;
	}

};
