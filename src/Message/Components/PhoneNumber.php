<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;
use function is_string, mb_strtolower, mb_strlen, preg_replace, trim;

class PhoneNumber /* @php8 Stringable */
{
    use Strict;

    public string $phone_number;

    public ?string $iso;


    public function __construct(string $phone_number, ?string $iso = null)
    {
        $this->phoneNumber($phone_number);
        $this->iso($iso);
    }


    public function phoneNumber(string $phone_number): self
    {
        $this->phone_number = self::formatNumber($phone_number);

        return $this;
    }


    public function iso(?string $iso): self
    {
        if (is_string($iso) && mb_strlen($iso) === 2)
        {
            $this->iso = mb_strtolower($iso);
        }
        else if ($iso === null)
        {
            $this->iso = null;
        }

        return $this;
    }


    protected static function formatNumber(string $number): string
    {
        return (string) preg_replace(
            '~^0{2}~', '', (string) preg_replace(
                '~[^0-9]~', '', trim($number)
            )
        );
    }


    public function __toString(): string
    {
        return $this->phone_number;
    }
}
