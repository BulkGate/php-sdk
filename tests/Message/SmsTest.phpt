<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Tests;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\Message\Settings\Sms as SmsSettings, Sdk\Message\Sms};

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class SmsTest extends TestCase
{
    public function testSimple(): void
    {
        $sms = new Sms('420777777777', 'test');

        Assert::type(SmsSettings::class, $sms->settings);

        Assert::same('test', $sms->settings->text->text);
        Assert::same([], $sms->settings->text->variables);

        $sms->text('test1', ['test' => 'test']);

        Assert::same('test1', $sms->settings->text->text);
        Assert::same(['test' => 'test'], $sms->settings->text->variables);

        Assert::same(['sms'], $sms->getChannels());

        Assert::same('preparation', $sms->status);
        Assert::null($sms->message_id);
        Assert::null($sms->part_id);
        Assert::null($sms->error);

        $sms->updateStatus('scheduled', 'id', ['id']);

        Assert::same('scheduled', $sms->status);
        Assert::same('id', $sms->message_id);
        Assert::same(['id'], $sms->part_id);
        Assert::null($sms->error);

        $sms->updateStatus('error', null, null, 'error_message');

        Assert::same('error', $sms->status);
        Assert::null($sms->message_id);
        Assert::null($sms->part_id);
        Assert::same('error_message', $sms->error);

        Assert::same('420777777777', (string) $sms);
    }
}

(new SmsTest())->run();
