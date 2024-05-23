<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{Message\Component\Rcs\Suggestions, Utils\Strict, Message\Channel, Message\Component\Rcs\Suggestion\Suggestion};
use function array_pad;

class RcsFile implements Rcs
{
	use Strict;
	use Suggestions;


	/**
	 * @param list<Suggestion> $suggestions
	 * @param int<60, max>|null $timeout
	 */
	public function __construct(
		public readonly string $url,
		public bool            $force_refresh = false,
		public string|null     $sender = null,
		public int|null        $timeout = null,
		array                  $suggestions = []
	)
	{
		$this->initSuggestions($suggestions);
	}


	public function configure(...$parameters): void
	{
		if (array_is_list($parameters))
		{
			[$channel, $sender, $timeout, $force_refresh] = array_pad($parameters, 4, null);

			if ($channel === Channel::RCS && (is_string($sender) || is_null($sender)) && ((is_int($timeout) && $timeout >= 60) || is_null($timeout)) && (is_bool($force_refresh) || is_null($force_refresh)))
			{
				$this->sender ??= $sender;
				$this->timeout ??= $timeout;
				$this->force_refresh ??= $force_refresh;
			}
		}
		else if (isset($parameters['channel']) && $parameters['channel'] === Channel::RCS)
		{
			$this->sender ??= isset($parameters['sender']) && is_string($parameters['sender']) ? $parameters['sender'] : $this->sender;
			$this->timeout ??= isset($parameters['timeout']) && is_int($parameters['timeout']) && $parameters['timeout'] >= 60 ? $parameters['timeout'] : $this->timeout;
			$this->force_refresh ??= isset($parameters['force_refresh']) && is_bool($parameters['force_refresh']) ? $parameters['force_refresh'] : $this->force_refresh;
		}
	}


	/**
	 * @return array{sender: string, expiration: int<60, max>, file: array{url: string, force_refresh: bool, suggestions: array<int, mixed>}}
	 */
	public function jsonSerialize(): array
	{
		return [
			'sender' => $this->sender ?? '',
			'expiration' => $this->timeout ?? self::DefaultExpiration,
			'file' => [
				'url' => $this->url,
				'force_refresh' => $this->force_refresh,
				'suggestions' => $this->serializeSuggestions(4),
			]
		];
	}
}
