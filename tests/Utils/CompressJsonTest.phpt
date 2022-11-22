<?php declare(strict_types=1);

namespace BulkGate\Sdk\Utils\Tests;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Utils\CompressJson;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class CompressJsonTest extends TestCase
{
    public object $iterator;

    /**
     * @var array<string, int>
     */
    public array $test_array = [
        'test' => 1
    ];


    public function testEncode(): void
    {
        Assert::same($this->test_array, CompressJson::decode(CompressJson::encode($this->test_array)));

        Assert::null(CompressJson::encode("\"\xC1\xBF\""));
    }


    public function testDecode(): void
    {
        Assert::same($this->test_array, CompressJson::decode('H4sIAAAAAAACCqtWKkktLlGyMqwFALR0evoKAAAA'));

        Assert::same($this->test_array, CompressJson::decode('H4sIAAAAAAACCqtWKkktLlGyMqwFALR0evoKAAAA'));

        Assert::null(CompressJson::decode('H4sIAAAAAAACCqtWKkktLlGyMq______________'));

        Assert::null(CompressJson::decode('H4sIAAAAAAACCquuVipJLS5RsjKsBQCZeHSvCwAAAA=='));

        Assert::same($this->test_array, CompressJson::decode(CompressJson::encode($this->test_array)));
    }
}

(new CompressJsonTest())->run();
