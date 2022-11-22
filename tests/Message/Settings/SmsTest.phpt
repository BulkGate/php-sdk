<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings\Tests;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\Message\Settings\Sms, Sdk\Message\Component\SimpleText};
use function json_encode;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
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

        // Restrict rewrite
        $sms->configure('sms', 'gOwn', '420777777777', false);

        Assert::same($text, $sms->text);
        Assert::same('gText', $sms->sender_id);
        Assert::same('BulkGate', $sms->sender_id_value);
        Assert::true($sms->unicode);
    }


    public function testConfigure(): void
    {
        $sms = new Sms($text = new SimpleText('test <a>', ['a' => 5]));

        Assert::same($text, $sms->text);
        Assert::null($sms->sender_id);
        Assert::null($sms->sender_id_value);
        Assert::null($sms->unicode);

        Assert::same('{"text":"test <a>","variables":{"a":5},"sender_id":"gSystem","sender_id_value":"","unicode":false}', json_encode($sms));

        $sms->configure('sms', 'gOwn', '420777777777', false);

        Assert::same($text, $sms->text);
        Assert::same('gOwn', $sms->sender_id);
        Assert::same('420777777777', $sms->sender_id_value);
        Assert::false($sms->unicode);
    }


    public function testUnicode(): void
    {
        $sms = new Sms($text = new SimpleText('test <a>', ['a' => 5]));

        Assert::same($text, $sms->text);
        Assert::null($sms->sender_id);
        $sms->sender_id = 'gTest';
        Assert::null($sms->sender_id_value);
        Assert::null($sms->unicode);

        $sms->configure('sms', 'gShort', 'TOP', true);

        Assert::same($text, $sms->text);
        Assert::same('gTest', $sms->sender_id);
        Assert::same('TOP', $sms->sender_id_value);
        Assert::true($sms->unicode);
    }
}

(new SmsTest())->run();
