<?php declare(strict_types=1);

namespace BulkGate\Sdk\Tests;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\{
    Configurator\SmsConfigurator,
    Country,
    InvalidStateException,
    Message\Api,
    Message\Bulk,
    Message\Sms,
    MessageSender,
    Scheduler\None,
    SenderException,
    Connection\Connection,
    Connection\Request,
    Connection\Response
};
use Mockery;

require __DIR__ . '/bootstrap.php';

/** @testCase */
class MessageSenderTest extends TestCase
{
    /** @var Connection|Mockery\Mock $connection */
    private $connection;

    private MessageSender $sender;

    public function setUp(): void
    {
        $this->connection = Mockery::mock(Connection::class);

        $this->sender = new MessageSender($this->connection);

        $this->sender->setTag('451');
        $this->sender->setScheduler(new None());

        $this->sender->addSenderConfigurator(new SmsConfigurator('gText', 'BulkGate', true));

        $this->sender->setDefaultCountry(Country::CZECH_REPUBLIC);
    }


    public function testMessage(): void
    {
        $this->connection->shouldReceive('send')->with(Mockery::on(function (Request $request): bool
        {
            Assert::same([
                'application/json',
                'transactional',
                '{"application_id":5,"primary_channel":"sms","phone_number":"420777777777","country":"cz","channels":{"sms":{"text":"test","variables":[],"sender_id":"gText","sender_id_value":"BulkGate","unicode":true}},"tag":"451"}',
            ], $request->encode('application/json', ['application_id' => 5]));

            return true;
        }))->andReturn(new Response('application/json', '{"data":{"status":"accepted","message_id":"sms-xxxtgkinpxu4","part_id":["sms-xxxtgkinpxu4"],"number":"420777777777","channel":"sms"}}'));

        $sms = new Sms('420777777777', 'test');

        Assert::same($sms, $this->sender->send($sms));

        Assert::same('accepted', $sms->status);
        Assert::same('sms-xxxtgkinpxu4', $sms->message_id);
    }


    public function testBulkMessage(): void
    {
        $this->connection->shouldReceive('send')->with(Mockery::on(function (Request $request): bool
        {
            Assert::same([
                'application/json',
                'promotional',
                '{"application_id":5,"messages":[{"primary_channel":"sms","phone_number":"420777777777","country":"cz","channels":{"sms":{"text":"test1","variables":[],"sender_id":"gText","sender_id_value":"BulkGate","unicode":true}}},{"primary_channel":"sms","phone_number":"420777777778","country":"cz","channels":{"sms":{"text":"test2","variables":[],"sender_id":"gText","sender_id_value":"BulkGate","unicode":true}}}]}',
            ], $request->encode('application/json', ['application_id' => 5]));

            return true;
        }))->andReturn(new Response('application/json', '{"data":{"total":{"status":{"sent":0,"accepted":2,"scheduled":0,"error":0,"blacklisted":0,"invalid_number":0,"invalid_sender":0}},"response":[{"status":"accepted","message_id":"idynxlatyikxhw-0","part_id":["idynxlatyikxhw-0"],"number":"420777777777","channel":"sms"},{"status":"accepted","message_id":"idynxlatyikxhw-1","part_id":["idynxlatyikxhw-1"],"number":"420777777778","channel":"sms"}]}}'));

        $bulk = new Bulk([new Sms('420777777777', 'test1'), new Sms('420777777778', 'test2')]);

        Assert::same($bulk, $this->sender->send($bulk));

        Assert::same('accepted', $bulk[0]->status);
        Assert::same('idynxlatyikxhw-0', $bulk[0]->message_id);

        Assert::same('accepted', $bulk[1]->status);
        Assert::same('idynxlatyikxhw-1', $bulk[1]->message_id);
    }


    public function testUnknown(): void
    {
        Assert::exception(fn () => $this->sender->send(new Api([])), SenderException::class, 'Unknown message \'BulkGate\Sdk\Message\Api\'');
    }


    public function testDefaultCountry(): void
    {
        Assert::exception(fn () => $this->sender->setDefaultCountry('czk'), InvalidStateException::class, 'Invalid ISO 3166-1 alpha-2 format - \'czk\'');
    }
}

(new MessageSenderTest())->run();
