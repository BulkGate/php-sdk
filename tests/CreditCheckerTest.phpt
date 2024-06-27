<?php declare(strict_types=1);

namespace BulkGate\Sdk\Tests;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Mockery;
use Tester\{Assert, TestCase};
use BulkGate\Sdk\{Connection\Connection, Connection\Request, Connection\Response, CreditChecker};

require __DIR__ . '/bootstrap.php';

/**
 * @testCase
 */
class CreditCheckerTest extends TestCase
{
    public function testChecker(): void
    {
        /** @var Connection|Mockery\Mock $connection */
        $connection = Mockery::mock(Connection::class);
        $connection->shouldReceive('send')->with(Mockery::on(function (Request $request): bool
        {
            Assert::same([
                'application/json',
                'info',
                '[]',
            ], $request->encode());

            return true;
        }))->once()->andReturn(new Response('application/json', '{"data":{"wallet":"bg0000000000000000","credit":10.0,"currency":"credits","free_messages":3,"datetime":"2022-11-22T15:41:58+01:00"}}'));

        $credit_checker = new CreditChecker($connection);

        Assert::same([
            'wallet' => 'bg0000000000000000',
            'credit' => 10.0,
            'currency' => 'credits',
            'free_messages' => 3,
            'datetime' => '2022-11-22T15:41:58+01:00',
        ], $credit_checker->check());
    }


    public function tearDown(): void
    {
        Mockery::close();
    }
}

(new CreditCheckerTest())->run();
