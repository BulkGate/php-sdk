<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\{Sdk\Utils\Strict, Sdk\TypeError};
use function is_string;

class Helpers
{
    use Strict;


    /**
     * @param Component\PhoneNumber|string|mixed $phone_number
     * @throws TypeError
     */
    public static function createNumber(/* @php8 Component\PhoneNumber|string */ $phone_number): Component\PhoneNumber
    {
        if ($phone_number instanceof Component\PhoneNumber)
        {
            return $phone_number;
        }
        else if (is_string($phone_number))
        {
            return new Component\PhoneNumber($phone_number);
        }
        else
        {
            throw new TypeError();
        }
    }
}
