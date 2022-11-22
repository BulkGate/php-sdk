<?php declare(strict_types=1);

namespace BulkGate\Sdk;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use function is_string;

class NumberChecker
{
    use Utils\Strict;

    private Connection\Connection $connection;


    public function __construct(Connection\Connection $connection)
    {
        $this->connection = $connection;
    }


    /**
     * @param array<array-key, string|Message\Component\PhoneNumber> $numbers
     * @return array<array-key, array{phone_number: string, valid: bool, country: string|null, call_prefix: int|null, network_code: string|null, network_name: string}>
     * @throws ApiException
     */
    public function check(array $numbers, ?string $iso = null): array
    {
        $data = [];

        foreach ($numbers as $number)
        {
            if (is_string($number))
            {
                $data[] = ['phone_number' => $number, 'country' => $iso];
            }
            else if ($number instanceof Message\Component\PhoneNumber)
            {
                $data[] = ['phone_number' => $number->phone_number, 'country' => $number->iso ?? $iso];
            }
        }

        $response = $this->connection->send(new Connection\Request('check-phone-numbers', new Message\Api(['numbers' => $data])));

        $response->checkException();

        return $response->getData();
    }
}
