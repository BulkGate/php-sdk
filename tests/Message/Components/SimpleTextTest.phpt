<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Tests;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\SimpleText;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class SimpleTextTest extends TestCase
{
    public function testSimple(): void
    {
        $text = new SimpleText();

        Assert::same('', (string) $text);
        Assert::same('', $text->text);
        Assert::same([], $text->variables);

        $text->text('test message <variable>', ['variable' => 'test']);

        Assert::same('test message <variable>', (string) $text);
        Assert::same('test message <variable>', $text->text);
        Assert::same(['variable' => 'test'], $text->variables);
    }


    public function testConstruct(): void
    {
        $text = new SimpleText('test message <variable2>', ['variable2' => 'test2']);

        Assert::same('test message <variable2>', (string) $text);
        Assert::same('test message <variable2>', $text->text);
        Assert::same(['variable2' => 'test2'], $text->variables);
    }
}

(new SimpleTextTest())->run();
