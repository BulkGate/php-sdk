<?php declare(strict_types=1);

namespace BulkGate\Model\Messaging\Message\Components\WhatsApp\Components\Test;

require __DIR__ . '/../../../../bootstrap.php';

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\WhatsApp\Components\FileType;


/**
 * @testCase
 */
class FileTypeTest extends TestCase
{
	public function testFileType(): void
	{
		Assert::same('DOCUMENT', FileType::Document->serialize());
		Assert::same('IMAGE', FileType::Image->serialize());
		Assert::same('AUDIO', FileType::Audio->serialize());
		Assert::same('STICKER', FileType::Sticker->serialize());
		Assert::same('VIDEO', FileType::Video->serialize());
	}
}

(new FileTypeTest())->run();
