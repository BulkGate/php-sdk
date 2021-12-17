<?php declare(strict_types=1);

namespace BulkGate\Sdk\Connection\Tests;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\{ApiException, Connection\Response};

require __DIR__ . '/../bootstrap.php';

/** @testCase */
class ResponseTest extends TestCase
{
    public function testBasic(): void
    {
        $request = new Response('application/json', '{"data":{"status":"accepted","message_id":"sms-xxxtgkinpxu4","part_id":["sms-xxxtgkinpxu4"],"number":"420777777777","channel":"sms"}}');

        Assert::same([
            'status' => 'accepted',
            'message_id' => 'sms-xxxtgkinpxu4',
            'part_id' => ['sms-xxxtgkinpxu4'],
            'number' => '420777777777',
            'channel' => 'sms',
        ], $request->getData());

        Assert::true($request->isSuccess());

        $request->checkException();
    }


    public function testBulk(): void
    {
        $request = new Response('application/json', '{"data":{"response": ["ok"]}}');

        Assert::same(['ok'], $request->getData());

        Assert::true($request->isSuccess());

        $request->checkException();
    }


    public function testError(): void
    {
        $request = new Response('application/json', '{"error": "error_message", "type": "error_type", "code": 400, "detail": null}');

        Assert::same([], $request->getData());

        Assert::false($request->isSuccess());

        Assert::exception(fn () => $request->checkException(), ApiException::class, 'error_message');
    }


    public function testInvalid(): void
    {
        $request = new Response('application/json', '{"code": 400, "detail": null}');

        Assert::same([], $request->getData());

        Assert::false($request->isSuccess());

        Assert::exception(fn () => $request->checkException(), ApiException::class, 'Unknown API Response');
    }


    public function testMalformed(): void
    {
        $request = new Response('application/json', '}');

        Assert::same([], $request->getData());

        Assert::false($request->isSuccess());

        Assert::exception(fn () => $request->checkException(), ApiException::class, 'Server response is malformed.');
    }
}

(new ResponseTest())->run();
