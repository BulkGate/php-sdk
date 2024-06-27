<?php declare(strict_types=1);

namespace BulkGate\Sdk\Tests;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Country;

require __DIR__ . '/bootstrap.php';

/**
 * @testCase
 */
class CountryTest extends TestCase
{
    public function testConstants(): void
    {
        Assert::same('CZ', Country::CZECH_REPUBLIC);
        Assert::same('SK', Country::SLOVAKIA);
        Assert::same('RU', Country::RUSSIAN_FEDERATION);
        Assert::same('US', Country::UNITED_STATES);
    }
}

(new CountryTest())->run();
