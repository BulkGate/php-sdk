<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Tests;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\Helpers;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class HelperTest extends TestCase
{
	public function testCreateDateTime(): void
	{
		$date_time_1 = new \DateTime('@1717075391');
		$date_time_2 = new \DateTime('2024-01-17T19:30:40Z');

		Assert::same(null, Helpers::createDateTime(datetime: null, timezone: 'Europe/Tallinn'));
		Assert::same($date_time_1->getTimestamp(), Helpers::createDateTime(datetime: 1717075391, timezone: 'Europe/Tallinn')->getTimestamp());
		Assert::same($date_time_2->getTimestamp(), Helpers::createDateTime(datetime: '2024-01-17T19:30:40Z', timezone: 'Europe/Tallinn')->getTimestamp());
		Assert::same($date_time_2->getTimestamp(), Helpers::createDateTime(datetime: new \DateTime('2024-01-17T19:30:40Z'), timezone: 'Europe/Tallinn')->getTimestamp());
		Assert::null(Helpers::createDateTime(datetime: 'dsgasfgs', timezone: 'test'));
	}


	public function testLink(): void
	{
		Assert::same('text link', Helpers::setLink(text: 'text', link: 'link'));
		Assert::same('text', Helpers::setLink(text: 'text', link: ''));
	}

}

(new HelperTest())->run();
