<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings\Tests;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Settings\Sms;
use BulkGate\Sdk\Message\Component\SimpleText;
use function json_encode;

require __DIR__ . '/../../bootstrap.php';

/** @testCase */
class SmsTest extends TestCase
{
    public function testSimple(): void
    {
        $sms = new Sms($text = new SimpleText('test <a>', ['a' => 5]), 'gText', 'BulkGate', true);

        Assert::same($text, $sms->text);
        Assert::same('gText', $sms->sender_id);
        Assert::same('BulkGate', $sms->sender_id_value);
        Assert::true($sms->unicode);

        Assert::same('{"text":"test <a>","variables":{"a":5},"sender_id":"gText","sender_id_value":"BulkGate","unicode":true}', json_encode($sms));

        $sms->configure('gOwn', '420777777777', false);

        Assert::same($text, $sms->text);
        Assert::same('gOwn', $sms->sender_id);
        Assert::same('420777777777', $sms->sender_id_value);
        Assert::false($sms->unicode);

        $sms->unicode = true;

        Assert::true($sms->unicode);

        $sms->configure('gShort');

        Assert::same($text, $sms->text);
        Assert::same('gShort', $sms->sender_id);
        Assert::same('', $sms->sender_id_value);
        Assert::false($sms->unicode);
    }
}

(new SmsTest())->run();
