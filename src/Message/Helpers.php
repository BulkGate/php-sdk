<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\{Sdk\Message\Component\SimpleText, Sdk\Utils\Strict, Sdk\TypeError};
use function is_string;

class Helpers
{
    use Strict;


    /**
     * @param Component\PhoneNumber|string|null|mixed $phone_number
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
            throw new TypeError('Phone number must be \'' . Component\PhoneNumber::class . '|string\'');
        }
    }


    /**
     * @param Component\SimpleText|string|null|mixed $text
     * @param array<string, string|float|int> $variables
     * @throws TypeError
     */
    public static function createText($text, array $variables = []): ?SimpleText
    {
        if ($text instanceof Component\SimpleText || $text === null)
        {
            return $text;
        }
        else if (is_string($text))
        {
            return new Component\SimpleText($text, $variables);
        }
        else
        {
            throw new TypeError('Text must be \'' . Component\SimpleText::class . '|string|null\'');
        }
    }
}
