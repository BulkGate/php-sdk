<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{Utils\Strict, Message\Channel};


class Helpers
{
	use Strict;


	/**
	 * @return array<array-key, mixed>
	 */
	public static function configureGeneral(string|null $initial_sender, int|null $initial_timeout, mixed ...$parameters): array
	{
		if (array_is_list($parameters))
		{
			[$channel, $sender, $timeout] = array_pad($parameters, 3, null);

			if ($channel !== Channel::SMS  && (is_string($sender) || is_null($sender)) && ((is_int($timeout) && $timeout >= 60) || is_null($timeout)))
			{
				$initial_sender ??= $sender;
				$initial_timeout ??= $timeout;
			}
		}
		else if (isset($parameters['channel']) && $parameters['channel'] !== Channel::SMS)
		{
			$initial_sender ??= isset($parameters['sender']) && is_string($parameters['sender']) ? $parameters['sender'] : $initial_sender;
			$initial_timeout ??= isset($parameters['timeout']) && is_int($parameters['timeout']) && $parameters['timeout'] >= 60 ? $parameters['timeout'] : $initial_timeout;
		}

		return [$initial_sender, $initial_timeout];
	}
}
