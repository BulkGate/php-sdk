<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;
use BulkGate\Sdk\Message\{Channel, Component\SimpleText};
use function array_pad;

class ViberText implements Viber
{
	use Strict;


	/**
	 * @param int<60, max>|null $timeout
	 */
	public function __construct(public readonly SimpleText $text, public int|null $timeout = null, public string|null $sender = null)
	{
	}


	public function configure(...$parameters): void
	{
		if (array_is_list($parameters))
		{
			[$channel, $sender, $timeout] = array_pad($parameters, 3, null);

			if ($channel === Channel::viber && (is_string($sender) || is_null($sender)) && ((is_int($timeout) && $timeout >= 60 ) || is_null($timeout)))
			{
				$this->sender ??= $sender;
				$this->timeout ??= $timeout;
			}
		}
		else if (isset($parameters['channel']) && $parameters['channel'] === Channel::viber)
		{
			$this->sender ??= isset($parameters['sender']) && is_string($parameters['sender']) ? $parameters['sender'] : $this->sender;
			$this->timeout ??= isset($parameters['timeout']) && is_int($parameters['timeout']) && $parameters['timeout'] >= 60 ? $parameters['timeout'] : $this->timeout;
		}
	}


	public function getText(): SimpleText|null
	{
		return $this->text;
	}


	/**
	 * @return array{text: string, sender: string|null, expiration: int, variables: array<array-key, scalar|null>}
	 */
	public function jsonSerialize(): array
	{
		return [
			'text' => (string)$this->text,
			'sender' => $this->sender,
			'expiration' => $this->timeout ?? self::DefaultExpiration,
			'variables' => $this->text->variables
		];
	}
}
