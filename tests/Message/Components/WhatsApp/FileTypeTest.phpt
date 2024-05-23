<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Components\WhatsApp\Test;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\WhatsApp\Components\FileType;
use function array_map;

/**
 * @testCase
 */
class FileTypeTest extends TestCase
{
	public function testEnum(): void
	{
		Assert::count(5, FileType::cases());

		Assert::same([
			FileType::Image,
			FileType::Video,
			FileType::Audio,
			FileType::Document,
			FileType::Sticker,
		], FileType::cases());

		Assert::same(['image', 'video', 'audio', 'document', 'sticker'], array_map(fn (FileType $type): string => $type->value, FileType::cases()));
	}
}

(new FileTypeTest())->run();
