<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use DateTimeZone;
use BulkGate\Sdk\Utils\Strict;
use function trim, strlen, preg_quote, preg_match, is_int, is_string;

class Helpers
{
	use Strict;

	public static function setLink(string $text, string $link, string $parameters = '', string $separator = '/'): string
	{
		if (strlen(trim($link)) > 0 && !preg_match('~' . preg_quote($link) . '$~', $text))
		{
			$link .= (trim($parameters) !== '' ? $separator . $parameters : '');

			return "$text $link";
		}
		return $text;
	}


	public static function createDateTime(\DateTime|string|int|null $datetime, string $timezone): \DateTime|null
	{
		try
		{
			return match (true)
			{
				$datetime === null => null,
				is_int($datetime) => (new \DateTime("@$datetime", new DateTimeZone($timezone)))->setTimezone(new DateTimeZone('UTC')),
				is_string($datetime) => (new \DateTime($datetime, new DateTimeZone($timezone)))->setTimezone(new DateTimeZone('UTC')),
				default => $datetime->setTimezone(new DateTimeZone('UTC')),
			};
		}
		catch (\Exception)
		{
			return null;
		}
	}
}
