<?php declare(strict_types=1);

namespace BulkGate\Sdk\Utils;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use function base64_decode, base64_encode, gzdecode, gzencode;

class CompressJson
{
	use Strict;


	public static function encode(mixed $data, int $encoding_mode = 9): string|null
	{
		try
		{
			$data = gzencode(Json::encode($data), $encoding_mode);

			if ($data !== false)
			{
				return base64_encode($data);
			}
		}
		catch (JsonException $e)
		{
		}

		return null;
	}


	public static function decode(string $data): mixed
	{
		try
		{
			$data = base64_decode($data, true);

			if ($data !== false)
			{
				$data = @gzdecode($data);

				if ($data !== false)
				{
					return Json::decode($data);
				}
			}
		}
		catch (JsonException)
		{
		}

		return null;
	}
}
