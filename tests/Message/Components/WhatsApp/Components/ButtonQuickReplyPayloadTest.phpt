<?php declare(strict_types=1);

namespace BulkGate\Model\Messaging\Message\Components\WhatsApp\Components\Test;

require __DIR__ . '/../../../../bootstrap.php';

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\WhatsApp\Components\ButtonQuickReplyPayload;

/**
 * @testCase
 */
class ButtonQuickReplyPayloadTest extends TestCase
{
	public function testBase(): void
	{
		Assert::same(['type' => 'payload', 'index' => 5, 'payload' => 'xxx'], (new ButtonQuickReplyPayload(5, 'xxx'))->serialize());
	}
}

(new ButtonQuickReplyPayloadTest())->run();
