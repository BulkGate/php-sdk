<?php declare(strict_types=1);

namespace BulkGate\Sdk\Connection;

/**
 * @author Lukáš Piják 2025 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;
use function preg_match, mb_strtolower;

class Helpers
{
	use Strict;

	public static function parseContentType(string $header): ?string
	{
		$header = mb_strtolower($header);

		if (preg_match('~content-type:\s([^\n;]+)~', mb_strtolower($header), $m))
		{
			[, $content_type] = $m;

			return $content_type;
		}
		return null;
	}


	public static function parseHttpCode(?string $header): ?int
	{
		if ($header === null)
		{
			return null;
		}

		$header = mb_strtolower($header);

		if (preg_match('~\s(\d{3})~', mb_strtolower($header), $m))
		{
			[, $code] = $m;

			return (int) $code;
		}
		return null;
	}
}
