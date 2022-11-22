<?php declare(strict_types=1);

namespace BulkGate\Sdk\Tests;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Mockery;
use Tester\{Assert, TestCase};
use BulkGate\Sdk\{Connection\Connection, Connection\Request, Connection\Response, Message\Component\PhoneNumber, NumberChecker};

require __DIR__ . '/bootstrap.php';

/**
 * @testCase
 */
class NumberCheckerTest extends TestCase
{
    public function testChecker(): void
    {
        /** @var Connection|Mockery\Mock $connection */
        $connection = Mockery::mock(Connection::class);
        $connection->shouldReceive('send')->with(Mockery::on(function (Request $request): bool
        {
            Assert::same([
                'application/json',
                'check-phone-numbers',
                '{"numbers":[{"phone_number":"608123456","country":"cz"},{"phone_number":"777777777","country":"cz"},{"phone_number":"420777777777","country":"cz"},{"phone_number":"603777777","country":"cz"}]}',
            ], $request->encode());

            return true;
        }))->once()->andReturn(new Response('application/json', '{
            "data": {
                "608123456": {
                    "phone_number": "420608123456",
                    "valid": true,
                    "country": "cz",
                    "call_prefix": 420,
                    "network_code": "23003",
                    "network_name": "Vodafone"
                }
            }
        }'));

        $number_checker = new NumberChecker($connection);

        Assert::same([
            608123456 => [
                'phone_number' => '420608123456',
                'valid' => true,
                'country' => 'cz',
                'call_prefix' => 420,
                'network_code' => '23003',
                'network_name' => 'Vodafone',
            ],
        ], $number_checker->check(['608123456', '777777777', '420777777777', new PhoneNumber('603777777')], 'cz'));
    }


    public function tearDown(): void
    {
        Mockery::close();
    }
}

(new NumberCheckerTest())->run();
