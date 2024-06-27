<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Tests;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\PhoneNumber;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class PhoneNumberTest extends TestCase
{
    public function testSimple(): void
    {
        $phone_number = new PhoneNumber('+ 420 x (608)x123x456', 'CZ');

        Assert::same('420608123456', $phone_number->phone_number);
        Assert::same('cz', $phone_number->iso);

        $phone_number->iso('sk');

        Assert::same('sk', $phone_number->iso);

        $phone_number->iso('usa');

        Assert::same('sk', $phone_number->iso);

        $phone_number->iso(null);

        Assert::null($phone_number->iso);
    }


    public function testFormat(): void
    {
        Assert::same('420608123456', (string) new PhoneNumber('420608123456', 'cz'));
        Assert::same('420608123456', (string) new PhoneNumber('+420(608)123-456', 'cz'));
        Assert::same('420608123456', (string) new PhoneNumber('     420 608 123 456       ', 'cz'));
        Assert::same('420608123456', (string) new PhoneNumber('+ 420 x 608x123x456', 'cz'));
        Assert::same('420608123456', (string) new PhoneNumber('+420 608 (123)-456', 'cz'));
        Assert::same('420608123456', (string) new PhoneNumber('00420608123456', 'cz'));
        Assert::same('0420608123456', (string) new PhoneNumber('0420608123456', 'cz'));
    }
}

(new PhoneNumberTest())->run();
