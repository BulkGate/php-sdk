<?php declare(strict_types=1);

namespace BulkGate\Sdk\Utils;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use function json_encode, json_decode, json_last_error, json_last_error_msg, defined;
use const JSON_PRESERVE_ZERO_FRACTION, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE, JSON_BIGINT_AS_STRING;

class Json
{
    use Strict;


    /**
     * @param mixed $value
     * @throws JsonException
     */
    public static function encode($value): string
    {
        $json = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | (defined('JSON_PRESERVE_ZERO_FRACTION') ? JSON_PRESERVE_ZERO_FRACTION : 0));

        if ($error = json_last_error())
        {
            throw new JsonException(json_last_error_msg(), $error);
        }

        return (string) $json;
    }


    /**
     * @return mixed
     * @throws JsonException
     */
    public static function decode(string $json)
    {
        $value = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);

        if ($error = json_last_error())
        {
            throw new JsonException(json_last_error_msg(), $error);
        }

        return $value;
    }
}
