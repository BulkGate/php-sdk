<?php declare(strict_types=1);

namespace BulkGate\Sdk\Scheduler\Tests;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\InvalidStateException, Sdk\Scheduler\Campaign, Sdk\Message\Component\SimpleText, Sdk\Message\Sms};

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class CampaignTest extends TestCase
{
    private const PER = 14;


    public function testSimple(): void
    {
        $scheduler = new Campaign(new \DateTime('@1639661235'));

        $message = new Sms('420777777777', new SimpleText('test'));

        Assert::null($message->schedule);

        for ($i = 0; $i < 100; $i++)
        {
            $scheduler->schedule($message);
            Assert::same(1639661235, $message->schedule);
        }
    }


    public function testRestrictions(): void
    {
        $scheduler = new Campaign(new \DateTime('@1639661235'));

        $scheduler->restriction(CampaignTest::PER, 2, 'days');

        $message = new Sms('420777777777', new SimpleText('test'));

        Assert::null($message->schedule);

        for ($k = 0; $k < 3; $k++)
        {
            for ($j = 0; $j < 10; $j++)
            {
                for ($i = 0; $i < CampaignTest::PER; $i++)
                {
                    $scheduler->schedule($message);

                    $time = 1639661235 + $j * 2 * 24 * 3_600;

                    Assert::same($time, $message->schedule);

                    Assert::with($scheduler, fn () => Assert::same('1639661235', $this->datetime->format('U')));

                    if (($i + 1) % CampaignTest::PER !== 0)
                    {
                        Assert::with($scheduler, fn () => Assert::same("$time", $this->datetime_working->format('U')));
                    }
                    Assert::with($scheduler, fn () => Assert::same(($i + 1) % CampaignTest::PER, $this->counter));
                }
            }
            $scheduler->reset();
        }

        Assert::with($scheduler, fn () => Assert::same('1639661235', $this->datetime->format('U')));
        Assert::with($scheduler, fn () => Assert::same('1639661235', $this->datetime_working->format('U')));
    }


    public function testRestrictionsErrors(): void
    {
        $scheduler = new Campaign(new \DateTime('@1639661235'));

        Assert::exception(fn () => $scheduler->restriction(50, 2, 'week'), InvalidStateException::class, 'Unit \'week\' in not valid. Available: day, days, hour, hours, minute, minutes');
    }
}

(new CampaignTest())->run();
