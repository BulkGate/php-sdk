<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;
use BulkGate\Sdk\Message\{Channel, Component\Rcs\Suggestion\Suggestion, Component\Rcs\Suggestions};
use function array_pad;

class RcsText implements Rcs
{
	use Strict;
	use Suggestions;

	/**
	 * @param array<Suggestion> $suggestions
	 * @param int<60, max>|null $timeout
	 */
	public function __construct(
		public string      $text,
		public string|null $sender = null,
		public int|null    $timeout = null,
		array              $suggestions = []
	)
	{
		$this->initSuggestions($suggestions);
	}


	public function configure(...$parameters): void
	{
		if (array_is_list($parameters))
		{
			[$channel, $sender, $timeout] = array_pad($parameters, 3, null);

			if ($channel === Channel::RCS && (is_string($sender) || is_null($sender)) && ((is_int($timeout) && $timeout >= 60) || is_null($timeout)))
			{
				$this->sender ??= $sender;
				$this->timeout ??= $timeout;
			}
		}
		else if (isset($parameters['channel']) && $parameters['channel'] === Channel::RCS)
		{
			$this->sender ??= isset($parameters['sender']) && is_string($parameters['sender']) ? $parameters['sender'] : $this->sender;
			$this->timeout ??= isset($parameters['timeout']) && is_int($parameters['timeout']) && $parameters['timeout'] >= 60 ? $parameters['timeout'] : $this->timeout;
		}
	}


	/**
	 * @return array{sender: string|null, expiration: int<60, max>|null, message: array{text: string, suggestions: array<int, mixed>}}
	 */
	public function jsonSerialize(): array
	{
		return [
			'sender' => $this->sender ?? '',
			'expiration' => $this->timeout ?? self::DefaultExpiration,
			'message' => [
				'text' => $this->text,
				'suggestions' => $this->serializeSuggestions(4),
			]
		];
	}
}
