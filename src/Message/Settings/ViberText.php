<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{Utils\Strict, Message\Channel, Message\Component\SimpleText};
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
		/*if (array_is_list($parameters))
		{
			[$channel, $sender, $timeout] = array_pad($parameters, 3, null);

			if ($channel === Channel::Viber && (is_string($sender) || is_null($sender)) && ((is_int($timeout) && $timeout >= 60 ) || is_null($timeout)))
			{
				$this->sender ??= $sender;
				$this->timeout ??= $timeout;
			}
		}
		else if (isset($parameters['channel']) && $parameters['channel'] === Channel::Viber)
		{
			$this->sender ??= isset($parameters['sender']) && is_string($parameters['sender']) ? $parameters['sender'] : $this->sender;
			$this->timeout ??= isset($parameters['timeout']) && is_int($parameters['timeout']) && $parameters['timeout'] >= 60 ? $parameters['timeout'] : $this->timeout;
		}*/

		[$this->sender, $this->timeout] = Helpers::configureGeneral($this->sender, $this->timeout, ...$parameters);
	}


	public function getText(): SimpleText
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
