<?php declare(strict_types=1);

namespace BulkGate\Sdk;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use function get_class, preg_match, mb_strtolower, is_string;

class MessageSender implements Sender
{
    use Utils\Strict;

    private Connection\Connection $connection;

    private ?Scheduler\Scheduler $scheduler = null;

    protected ?string $default_country = null;

    private string $tag = '';

    /**
     * @var array<string, Configurator\Configurator>
     */
    private array $configurators = [];


    public function __construct(Connection\Connection $connection)
    {
        $this->connection = $connection;
    }


    public function addSenderConfigurator(Configurator\Configurator $configurator): void
    {
        $this->configurators[$configurator->getChannel()] = $configurator;
    }


    public function setScheduler(?Scheduler\Scheduler $scheduler): void
    {
        $this->scheduler = $scheduler;
    }


    public function setTag(string $tag): void
    {
        $this->tag = $tag;
    }


    /**
     * @throws InvalidStateException
     */
    public function setDefaultCountry(?string $country): self
    {
        if ($country !== null && !preg_match('~^[a-zA-Z]{2}$~', $country))
        {
            throw new InvalidStateException("Invalid ISO 3166-1 alpha-2 format - '$country'");
        }

        $this->default_country = is_string($country) ? mb_strtolower($country) : null;

        return $this;
    }


    /**
     * @throws SenderException
     * @throws ApiException
     */
    public function send(Message\Send $message): Message\Send
    {
        if ($message instanceof Message\Bulk)
        {
            return $this->sendBulk($message);
        }
        else if ($message instanceof Message\Base)
        {
            return $this->sendBase($message);
        }
        else
        {
            throw new SenderException("Unknown message '" . get_class($message) . "'");
        }
    }


    /**
     * @throws ApiException
     */
    private function sendBase(Message\Base $message): Message\Base
    {
        $this->configure($message);

        $response = $this->connection->send(new Connection\Request('transactional', $message, [
            'tag' => $this->tag
        ]));

        $response->checkException();

        $message_status = $response->getData();

        $message->updateStatus(
            $message_status['status'] ?? 'error',
            $message_status['message_id'] ?? null,
            $message_status['part_id'] ?? null,
            $message_status['error'] ?? null,
        );

        return $message;
    }


    /**
     * @throws ApiException
     */
    private function sendBulk(Message\Bulk $message): Message\Bulk
    {
        foreach ($message as $m)
        {
            $this->configure($m);
        }

        $response = $this->connection->send(new Connection\Request('promotional', $message, [
            'tag' => $this->tag
        ]));

        $response->checkException();

        $message_status_list = $response->getData();

        $message_key = 0;

        foreach ($message as $m)
        {
            $message_status = $message_status_list[$message_key] ?? null;

            if ($message_status !== null && $m instanceof Message\Base)
            {
                $m->updateStatus(
                    $message_status['status'] ?? 'error',
                    $message_status['message_id'] ?? null,
                    $message_status['part_id'] ?? null,
                    $message_status['error'] ?? null,
                );
            }

            $message_key ++;
        }

        return $message;
    }


    private function configure(Message\Base $message): void
    {
        if ($this->scheduler !== null)
        {
            $this->scheduler->schedule($message);
        }

        foreach ($message->getChannels() as $channel)
        {
            if (isset($this->configurators[$channel]))
            {
                $message->phone_number->iso ??= $this->default_country;

                $this->configurators[$channel]->configure($message);
            }
        }
    }
}
