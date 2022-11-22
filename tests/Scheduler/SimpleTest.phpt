<?php declare(strict_types=1);

namespace BulkGate\Sdk\Scheduler\Tests;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\Scheduler\Simple, Sdk\Message\Component\SimpleText, Sdk\Message\Sms};

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class SimpleTest extends TestCase
{
    public function testSimple(): void
    {
        $scheduler = new Simple(new \DateTime('@1639661235'));

        $message = new Sms('420777777777', new SimpleText('test'));

        Assert::null($message->schedule);

        $scheduler->schedule($message);

        Assert::same(1639661235, $message->schedule);
    }
}

(new SimpleTest())->run();
