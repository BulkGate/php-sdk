<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Rcs;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use function strlen, substr, preg_replace;

class Helpers
{
	public static function detectBasic(string $text, bool $suggestions = false): string
	{
		return strlen($text) <= 160 && !$suggestions ? 'basic' : 'single';
	}


	public static function sanitizeSuggestionTitle(string $title): string
	{
		return substr(preg_replace('~\s~', ' ', $title) ?? '', 0, 25);
	}
}
