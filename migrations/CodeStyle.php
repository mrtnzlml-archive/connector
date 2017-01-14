<?php declare(strict_types = 1);

namespace Adeira\Connector\Migrations;

class CodeStyle implements \Zenify\DoctrineMigrations\Contract\CodeStyle\CodeStyleInterface
{

	public function applyForFile(string $file)
	{
		$code = file_get_contents($file);
		$code = preg_replace('~ {4}~', "\t", $code); // use tabs
		$code = preg_replace('~\n\t?/\\*\\*.*?\\*/~s', "\r", $code); // remove PHP doc comments
		$code = preg_replace("~\n{.*?public~s", "\n{\n\n\tpublic", $code); // adjust spacing (beginning of class)
		$code = preg_replace("~}\n}~", "}\n\n}", $code); // adjust spacing (end of class)
		$code = preg_replace("~<\\?php\n~", "<?php declare(strict_types = 1);\n", $code); // PHP 7
		file_put_contents($file, $code);
	}

}
