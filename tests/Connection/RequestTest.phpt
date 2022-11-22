<?php declare(strict_types=1);

namespace BulkGate\Sdk\Connection\Tests;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, Expect, TestCase};
use BulkGate\Sdk\{Connection\Request, Message\Api};
use function serialize;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class RequestTest extends TestCase
{
    public function testBasic(): void
    {
        $request = new Request('action', new Api(['test' => true]));

        Assert::same(['application/json', 'action', '{"auth":true,"test":true}'], $request->encode('application/json', ['auth' => true]));
    }


    public function testExtraContentType(): void
    {
        $request = new Request('action', new Api(['test' => true]));

        Assert::same(['application/json', 'action', '{"auth":true,"test":true}'], $request->encode('application/serialize', ['auth' => true]));

        $request->encoders['application/serialize'] = fn ($data) => serialize($data);

        Assert::same(['application/serialize', 'action', 'a:2:{s:4:"auth";b:1;s:4:"test";b:1;}'], $request->encode('application/serialize', ['auth' => true]));
    }


    public function testCompress(): void
    {
        $request = new Request('action', new Api(['test' => true]));

        Assert::equal(['application/base64+gzip+json', 'action', Expect::match('%S%')], $request->encode('application/base64+gzip+json', ['auth' => true]));
    }
}

(new RequestTest())->run();
