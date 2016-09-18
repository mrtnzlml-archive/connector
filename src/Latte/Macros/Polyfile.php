<?php

namespace App\Latte\Macros;

use Latte;
use Latte\Helpers;
use Latte\MacroNode;
use Latte\PhpWriter;

class Polyfile extends \Latte\Macros\MacroSet
{

	public static function install(Latte\Compiler $compiler)
	{
		$me = new static($compiler);
		$me->addMacro('polyfile', [$me, 'macroPolyfile']);
	}

	/**
	 * {polyfile "file" [,] [params]}
	 */
	public function macroPolyfile(MacroNode $node, PhpWriter $writer)
	{
		$node->replaced = FALSE;
		$noEscape = Helpers::removeFilter($node->modifiers, 'noescape');
		if (!$noEscape && Helpers::removeFilter($node->modifiers, 'escape')) {
			trigger_error('Macro {polyfile} provides auto-escaping, remove |escape.');
		}
		if ($node->modifiers && !$noEscape) {
			$node->modifiers .= '|escape';
		}
		return $writer->write(
			'/* line ' . $node->startLine . ' */
			$this->global->uiControl->getComponent(\'polyfile\')->addPolyfile(%node.word)'
		);
	}

}
