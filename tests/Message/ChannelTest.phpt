<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Tests;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Channel;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class ChannelTest extends TestCase
{
    public function testSimple(): void
    {
        Assert::same('viber', Channel::VIBER);
        Assert::same('sms', Channel::SMS);
    }
}

(new ChannelTest())->run();
