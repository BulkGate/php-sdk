<?php declare(strict_types=1);

namespace BulkGate\Sdk\Configurator\Tests;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Configurator\PrefixMap;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class PrefixMapTest extends TestCase
{
    public function testConstants(): void
    {
        Assert::same('us', PrefixMap::PREFIX_TO_ISO['1']);
        Assert::same('cz', PrefixMap::PREFIX_TO_ISO['420']);
        Assert::same('ru', PrefixMap::PREFIX_TO_ISO['7']);
    }
}

(new PrefixMapTest())->run();
