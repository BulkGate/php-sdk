<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Tests;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\Button;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class ButtonTest extends TestCase
{
    public function testSimple(): void
    {
        $button = new Button('test1', 'url1');

        Assert::same('test1', $button->caption);
        Assert::same('url1', $button->url);

        $button->caption = 'test2';
        $button->url = 'url2';

        Assert::same('test2', $button->caption);
        Assert::same('url2', $button->url);
    }
}

(new ButtonTest())->run();
