<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Tests;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\TypeError;
use BulkGate\Sdk\Message\{Settings\Viber as ViberSettings, Viber};

require __DIR__ . '/../bootstrap.php';

/** @testCase */
class ViberTest extends TestCase
{
    public function testSimple(): void
    {
        Assert::exception(fn () => new Viber(false, false), TypeError::class, 'Phone number must be \'BulkGate\Sdk\Message\Component\PhoneNumber|string\'');
        Assert::exception(fn () => new Viber('4206087777777', false), TypeError::class, 'Text must be \'BulkGate\Sdk\Message\Component\SimpleText|string|null\'');

        $viber = new Viber('420777777777', 'test');

        Assert::type(ViberSettings::class, $viber->settings);

        Assert::same('test', $viber->settings->text->text);
        Assert::same([], $viber->settings->text->variables);

        $viber->text('test1', ['test' => 'test']);

        Assert::same('test1', $viber->settings->text->text);
        Assert::same(['test' => 'test'], $viber->settings->text->variables);

        Assert::same(['viber'], $viber->getChannels());

        Assert::same('preparation', $viber->status);
        Assert::null($viber->message_id);
        Assert::null($viber->part_id);
        Assert::null($viber->error);

        $viber->updateStatus('scheduled', 'id', ['id']);

        Assert::same('scheduled', $viber->status);
        Assert::same('id', $viber->message_id);
        Assert::same(['id'], $viber->part_id);
        Assert::null($viber->error);

        $viber->updateStatus('error', null, null, 'error_message');

        Assert::same('error', $viber->status);
        Assert::null($viber->message_id);
        Assert::null($viber->part_id);
        Assert::same('error_message', $viber->error);

        Assert::same('420777777777', (string) $viber);
    }
}

(new ViberTest())->run();
