<?php declare(strict_types=1);

namespace BulkGate\Sdk\Scheduler\Tests;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\Scheduler\None, Sdk\Message\Component\SimpleText, Sdk\Message\Sms};

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class NoneTest extends TestCase
{
    public function testSimple(): void
    {
        $scheduler = new None();

        $message = new Sms('420777777777', new SimpleText('test'));

        Assert::null($message->schedule);

        $scheduler->schedule($message);

        Assert::null($message->schedule);
    }
}

(new NoneTest())->run();
