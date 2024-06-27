<?php declare(strict_types=1);

namespace BulkGate\Sdk;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use function is_string;

class NumberChecker
{
	use Utils\Strict;

	public function __construct(private readonly Connection\Connection $connection)
	{
	}


	/**
	 * @param array<array-key, string|Message\Component\PhoneNumber|mixed> $numbers
	 * @return array<array-key, array{phone_number: string, valid: bool, country: string|null, call_prefix: int|null, network_code: string|null, network_name: string}>
	 * @throws ApiException
	 */
	public function check(array $numbers, string|null $iso = null): array
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
