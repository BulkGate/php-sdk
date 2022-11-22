<?php declare(strict_types=1);

namespace BulkGate\Sdk\Connection;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;
use function preg_match, mb_strtolower;

class Helpers
{
    use Strict;


    public static function parseContentType(string $header): ?string
    {
        $header = strtolower($header);

        if (preg_match('~content-type:\s([^\n;]+)~', mb_strtolower($header), $m))
        {
            [, $content_type] = $m;

            return $content_type;
        }
        return null;
    }
}
