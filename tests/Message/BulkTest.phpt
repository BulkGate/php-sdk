<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Tests;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\{Bulk, Sms, Viber};
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

        $bulk[] = 150;

        $bulk['sms'] = $sms_with_key = new Sms('420777777779', 'test');

        Assert::same('{"messages":[{"primary_channel":"sms","phone_number":"420777777777","country":null,"schedule":null,"channels":{"sms":{"text":"test","variables":[],"sender_id":"gSystem","sender_id_value":"","unicode":false}}},{"primary_channel":"viber","phone_number":"420777777778","country":null,"schedule":null,"channels":{"viber":{"text":"test","variables":[],"sender":null,"button_caption":"OK","button_url":"#","image":null,"image_zoom":false,"expiration":10800}}},{"primary_channel":"sms","phone_number":"420777777779","country":null,"schedule":null,"channels":{"sms":{"text":"test","variables":[],"sender_id":"gSystem","sender_id_value":"","unicode":false}}}]}', json_encode($bulk));

        Assert::count(3, $bulk);

        Assert::same($sms, $bulk[0]);
        Assert::same($viber, $bulk[1]);
        Assert::same($sms_with_key, $bulk['sms']);
    }
}

(new BulkTest())->run();
