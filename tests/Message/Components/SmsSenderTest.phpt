<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Components\Tests;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\SmsSender;

require __DIR__ . '/../../bootstrap.php';

/** @testCase */
class SmsSenderTest extends TestCase
{
    public function testSimple(): void
    {
        Assert::same('', SmsSender::DEFAULT_SENDER);

        Assert::same('gSystem', SmsSender::GATE_SYSTEM_NUMBER);
        Assert::same('gShort', SmsSender::GATE_SHORT_CODE);
        Assert::same('gText', SmsSender::GATE_TEXT_SENDER);
        Assert::same('gOwn', SmsSender::GATE_OWN_NUMBER);
        Assert::same('gMobile', SmsSender::GATE_MOBILE_CONNECT);
        Assert::same('gProfile', SmsSender::GATE_PORTAL_PROFILE);

        Assert::same('gGate1', SmsSender::GATE1);
        Assert::same('gGate2', SmsSender::GATE2);
        Assert::same('gGate3', SmsSender::GATE3);
        Assert::same('gGate4', SmsSender::GATE4);
        Assert::same('gGate5', SmsSender::GATE5);
        Assert::same('gGate6', SmsSender::GATE6);
        Assert::same('gGate7', SmsSender::GATE7);
    }
}

(new SmsSenderTest())->run();
