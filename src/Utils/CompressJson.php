<?php declare(strict_types=1);

namespace BulkGate\Sdk\Utils;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use function base64_decode, base64_encode, gzdecode, gzencode;

class CompressJson
{
    use Strict;


    /**
     * @param mixed $data
     */
    public static function encode($data, int $encoding_mode = 9): ?string
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


    /**
     * @return mixed
     */
    public static function decode(string $data)
    {
        try
        {
            $data = base64_decode($data);

            if ($data !== false)
            {
                $data = @gzdecode($data);

                if ($data !== false)
                {
                    return Json::decode($data);
                }
            }
        }
        catch (JsonException $e)
        {
        }

        return null;
    }
}
