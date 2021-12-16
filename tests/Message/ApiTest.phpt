<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Tests;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Api;
use function json_encode;

require __DIR__ . '/../bootstrap.php';

/** @testCase */
class ApiTest extends TestCase
{
    public function testSimple(): void
    {
        Assert::same('{"data":"temp"}', json_encode(new Api(['data' => 'temp'])));
    }
}

(new ApiTest())->run();
