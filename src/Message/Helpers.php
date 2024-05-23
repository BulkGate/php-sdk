<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\{Sdk\Message\Component\SimpleText, Sdk\Utils\Strict};
use function is_string;

class Helpers
{
	use Strict;

	public static function createNumber(Component\PhoneNumber|string $phone_number): Component\PhoneNumber
	{
		if (is_string($phone_number))
		{
			$phone_number = new Component\PhoneNumber($phone_number);
		}

		return $phone_number;
	}


	/**
	 * @param array<string, scalar|null> $variables
	 */
	public static function createText(Component\SimpleText|string|null $text, array $variables = []): SimpleText|null
	{
		if (is_string($text))
		{
			$text = new Component\SimpleText($text, $variables);
		}

		return $text;
	}
}
