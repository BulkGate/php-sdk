<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Tests;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\{Bulk, Rcs, Sms, Viber, WhatsApp};
use function json_encode;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class BulkTest extends TestCase
{
    public function testSimple(): void
    {
        $bulk = new Bulk([$sms = new Sms('420777777777', 'test'), 'invalid_message']);

        $bulk[] = $viber = new Viber('420777777778', 'test');

		$bulk[] = $rcs = new Rcs('420777777777', text: 'test', sender: 'BulkGate');

		$bulk[] = $whatsapp = new WhatsApp('420777777777', text: 'text', sender: 'BulkGate');

        $bulk[] = 150;

        $bulk['sms'] = $sms_with_key = new Sms('420777777779', 'test');


        Assert::same('{"messages":[{"primary_channel":"sms","phone_number":"420777777777","country":null,"schedule":null,"channels":{"sms":{"text":"test","variables":[],"sender_id":"gSystem","sender_id_value":"","unicode":false}}},{"primary_channel":"viber","phone_number":"420777777778","country":null,"schedule":null,"channels":{"viber":{"text":"test","sender":null,"expiration":60,"variables":[]}}},{"primary_channel":"rcs","number":"420777777777","country":null,"schedule":null,"channels":{"rcs":{"sender":"BulkGate","expiration":60,"message":{"text":"test","suggestions":[]}}}},{"primary_channel":"whatsapp","number":"420777777777","country":null,"schedule":null,"channels":{"whatsapp":{"sender":"BulkGate","expiration":180,"message":{"text":"text","preview_url":true}}}},{"primary_channel":"sms","phone_number":"420777777779","country":null,"schedule":null,"channels":{"sms":{"text":"test","variables":[],"sender_id":"gSystem","sender_id_value":"","unicode":false}}}]}', json_encode($bulk));

        Assert::count(5, $bulk);

        Assert::same($sms, $bulk[0]);
        Assert::same($viber, $bulk[1]);
		Assert::same($rcs, $bulk[2]);
		Assert::same($whatsapp, $bulk[3]);
        Assert::same($sms_with_key, $bulk['sms']);
    }
}

(new BulkTest())->run();
