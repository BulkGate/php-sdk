<?php declare(strict_types=1);

namespace BulkGate\Model\Messaging\Message\Components\WhatsApp\Components\Test;

require __DIR__ . '/../../../../bootstrap.php';

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\WhatsApp\Components\ButtonUrlParameter;

/**
 * @testCase
 */
class ButtonUrlParameterTest extends TestCase
{
	public function testBase(): void
	{
		Assert::same([
			'type' => 'url',
			'index' => 5,
			'text' => 'xxx'
		], (new ButtonUrlParameter(5, 'xxx'))->serialize());
	}
}

(new ButtonUrlParameterTest())->run();
