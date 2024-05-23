<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Tests;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\Message\Component\Rcs\Variant, Sdk\Message\Rcs, Sdk\Message\Settings\Rcs as RcsSettings};

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class RcsTest extends TestCase
{
	public function testSimple(): void
	{
		$rcs = new Rcs('420777777777', Variant::Text, text: 'test');

		Assert::type(RcsSettings::class, $rcs->settings);

		Assert::same('test', $rcs->settings->text);

		Assert::same(['rcs'], $rcs->getChannels());

		Assert::same('preparation', $rcs->status);
		Assert::null($rcs->message_id);
		Assert::null($rcs->part_id);
		Assert::null($rcs->error);

		$rcs->updateStatus('scheduled', 'id', ['id']);

		Assert::same('scheduled', $rcs->status);
		Assert::same('id', $rcs->message_id);
		Assert::same(['id'], $rcs->part_id);
		Assert::null($rcs->error);

		$rcs->updateStatus('error', null, null, 'error_message');

		Assert::same('error', $rcs->status);
		Assert::null($rcs->message_id);
		Assert::null($rcs->part_id);
		Assert::same('error_message', $rcs->error);

		Assert::same('420777777777', (string) $rcs);
	}
}

(new RcsTest())->run();
