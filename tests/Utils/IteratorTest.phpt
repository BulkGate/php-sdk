<?php declare(strict_types=1);

namespace BulkGate\Sdk\Utils\Tests;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Utils\{Iterator};
use function iterator_to_array, json_encode;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class IteratorTest extends TestCase
{
    public object $iterator;

    /**
     * @var array<string, int>
     */
    public array $test_array = [
        'test' => 1
    ];


    public function setUp(): void
    {
        $this->iterator = new class ($this->test_array) extends Iterator
        {
            public function __construct(array $list)
            {
                $this->list = $list;
            }
        };
    }


    public function testIterator(): void
    {
        $array = [];

        foreach ($this->iterator as $key => $item)
        {
            $array[$key] = $item;
        }

        Assert::same($this->test_array, $array);
    }


    public function testArrayAccess(): void
    {
        Assert::same(null, $this->iterator['test1']);

        Assert::false(isset($this->iterator['test1']));

        $this->iterator[] = 10;
        $this->iterator['test1'] = 50;

        Assert::true(isset($this->iterator['test1']));

        Assert::same(['test' => 1, 10, 'test1' => 50], iterator_to_array($this->iterator));

        Assert::same(50, $this->iterator['test1']);

        unset($this->iterator['test1']);

        Assert::false(isset($this->iterator['test1']));
    }


    public function testCount(): void
    {
        Assert::count(1, $this->iterator);

        $this->iterator[] = 5;

        Assert::count(2, $this->iterator);

        unset($this->iterator['test']);

        Assert::count(1, $this->iterator);

        Assert::same([5], iterator_to_array($this->iterator));
    }


    public function testJsonEncode(): void
    {
        Assert::same('[1]', json_encode($this->iterator));

        $this->iterator[] = ['1' => 'a'];

        Assert::same('[1,{"1":"a"}]', json_encode($this->iterator));
    }
}

(new IteratorTest())->run();
