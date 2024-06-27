<?php declare(strict_types=1);

namespace BulkGate\Sdk\Utils\Tests;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Utils\{Json, JsonException};

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class JsonTest extends TestCase
{
    public function testEncode(): void
    {
        Assert::same('"BulkGate"', Json::encode('BulkGate'));
        Assert::exception(fn() => Json::encode("\"\xC1\xBF\""), JsonException::class);
        Assert::same('{"MrB":451}', Json::encode(['MrB' => 451]));
        Assert::same('{"MrB":451}', Json::encode(Json::decode('{"MrB": 451}')));
    }


    public function testEncodeErrors(): void
    {
        Assert::exception(fn() => Json::encode("\"\xC1\xBF\""), JsonException::class);
    }


    public function testDecode(): void
    {
        Assert::same('BulkGate', Json::decode('"BulkGate"'));
        Assert::null(Json::decode('null'));
        Assert::null(Json::decode(' null '));
        Assert::same(['MrB' => 451], Json::decode('{"MrB": 451}'));
        Assert::same(['MrB' => 451], Json::decode(Json::encode(['MrB' => 451])));
    }
    
    
    public function testDecodeErrors(): void
    {
        Assert::exception(fn() => Json::decode(''), JsonException::class);
        Assert::exception(fn() => Json::decode('NULL'), JsonException::class);
        Assert::exception(fn() => Json::decode('{'), JsonException::class);
        Assert::exception(fn() => Json::decode('{}}'), JsonException::class);
        Assert::exception(fn() => Json::decode("\x10"), JsonException::class);
        Assert::exception(fn() => Json::decode("\"\xC1\xBF\""), JsonException::class);
    }
}

(new JsonTest())->run();
