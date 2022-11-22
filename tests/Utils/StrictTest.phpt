<?php declare(strict_types=1);

namespace BulkGate\Sdk\Utils\Tests;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Utils\{Strict, StrictException};

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class StrictTest extends TestCase
{
    public object $test;


    public function setUp(): void
    {
        $this->test = new class ()
        {
            use Strict;

            public bool $defined = true;

            public function defined(): bool
            {
                return true;
            }

            public static function staticDefined(): bool
            {
                return true;
            }
        };
    }


    public function testProperties(): void
    {
        Assert::exception(fn () => $this->test->undefined = 'undefined', StrictException::class);

        Assert::exception(function (): void
        {
            echo $this->test->undefined;
        }, StrictException::class);

        Assert::exception(function (): void
        {
            unset($this->test->undefined);
        }, StrictException::class);


        Assert::false(isset($this->test->undefined));

        Assert::true($this->test->defined);

        Assert::true($this->test->defined());

        Assert::true($this->test::staticDefined());

        $this->test->defined = false;

        Assert::false($this->test->defined);

        unset($this->test->defined);

        Assert::exception(function(): void
        {
            echo $this->test->defined;
        }, StrictException::class);
    }


    public function testMethods(): void
    {
        Assert::exception(function (): void
        {
            $this->test->undefined();
        }, StrictException::class);

        Assert::exception(function (): void
        {
            $this->test::undefined();
        }, StrictException::class);
    }
}

(new StrictTest())->run();
