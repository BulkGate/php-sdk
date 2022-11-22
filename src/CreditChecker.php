<?php declare(strict_types=1);

namespace BulkGate\Sdk;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

class CreditChecker
{
    use Utils\Strict;

    private Connection\Connection $connection;


    public function __construct(Connection\Connection $connection)
    {
        $this->connection = $connection;
    }


    /**
     * @return array{wallet: string, credit: float, currency: string, free_messages: int, datetime: string}|array<array-key, mixed>
     * @throws ApiException
     */
    public function check(): array
    {
        $response = $this->connection->send(new Connection\Request('info', new Message\Api()));

        $response->checkException();

        return $response->getData();
    }
}
