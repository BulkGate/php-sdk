<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Tests;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\TypeError, Sdk\Message\Component\PhoneNumber, Sdk\Message\Component\SimpleText, Sdk\Message\Helpers};

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class HelpersTest extends TestCase
{
    public function testCreateNumber(): void
    {
        Assert::same('420777777777', (string) Helpers::createNumber('420777777777'));
        Assert::same('420777777777', (string) Helpers::createNumber(new PhoneNumber('420777777777')));

        Assert::exception(fn () => Helpers::createNumber(150), TypeError::class, 'Phone number must be \'BulkGate\Sdk\Message\Component\PhoneNumber|string\'');
        Assert::exception(fn () => Helpers::createNumber(150.5), TypeError::class, 'Phone number must be \'BulkGate\Sdk\Message\Component\PhoneNumber|string\'');
        Assert::exception(fn () => Helpers::createNumber(null), TypeError::class, 'Phone number must be \'BulkGate\Sdk\Message\Component\PhoneNumber|string\'');
        Assert::exception(fn () => Helpers::createNumber(new \stdClass()), TypeError::class, 'Phone number must be \'BulkGate\Sdk\Message\Component\PhoneNumber|string\'');
        Assert::exception(fn () => Helpers::createNumber([5]), TypeError::class, 'Phone number must be \'BulkGate\Sdk\Message\Component\PhoneNumber|string\'');
    }


    public function testCreateText(): void
    {
        Assert::same('420777777777', (string) Helpers::createText('420777777777'));
        Assert::same('420777777777', (string) Helpers::createText(new SimpleText('420777777777')));
        Assert::null(Helpers::createText(null));

        Assert::exception(fn () => Helpers::createText(150), TypeError::class, 'Text must be \'BulkGate\Sdk\Message\Component\SimpleText|string|null\'');
        Assert::exception(fn () => Helpers::createText(150.5), TypeError::class, 'Text must be \'BulkGate\Sdk\Message\Component\SimpleText|string|null\'');
        Assert::exception(fn () => Helpers::createText(new \stdClass()), TypeError::class, 'Text must be \'BulkGate\Sdk\Message\Component\SimpleText|string|null\'');
        Assert::exception(fn () => Helpers::createText([5]), TypeError::class, 'Text must be \'BulkGate\Sdk\Message\Component\SimpleText|string|null\'');
    }
}

(new HelpersTest())->run();
