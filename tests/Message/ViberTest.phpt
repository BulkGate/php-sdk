<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Tests;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\Message\Component\Viber\Variant, Sdk\Message\Settings\Viber as ViberSettings, Sdk\Message\Viber};

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class ViberTest extends TestCase
{
    public function testSimple(): void
    {
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


	    $viber = new Viber(phone_number: '420777777777', text: 'test', variant: Variant::Card);

	    $viber->text('test_card', ['test' => 'test_card']);

	    Assert::same('test_card', $viber->settings->text->text);
	    Assert::same(['test' => 'test_card'], $viber->settings->text->variables);
    }
}

(new ViberTest())->run();
