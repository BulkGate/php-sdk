<?php declare(strict_types=1);

namespace BulkGate\Model\Messaging\Message\Components\Rcs\Suggestion\Test;

require __DIR__ . '/../../../../bootstrap.php';

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\Rcs\Suggestion\Reply;

/**
 * @testCase
 */
class ReplyTest extends TestCase
{
	public function testAction(): void
	{
		Assert::equal(['type' => 'reply', 'text' => 'button_text', 'postback' => 'postback2'], (new Reply(text: 'button_text', postback: 'postback2'))->serialize());
		Assert::equal(['type' => 'reply', 'text' => 'button_text', 'postback' => 'ok'], (new Reply('button_text'))->serialize());
	}
}

(new ReplyTest())->run();
