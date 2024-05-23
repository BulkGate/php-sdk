<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;
use BulkGate\Sdk\Message\{Channel, Component\Rcs\Card, Component\Rcs\Height, Component\Rcs\Suggestion\Suggestion};
use function array_pad;

class RcsCard implements Rcs
{
	use Strict;


	/**
	 * @param array<Suggestion> $suggestions
	 * @param int<60, max>|null $timeout
	 */
	public function __construct(
		public readonly string      $title,
		public readonly string      $description,
		public readonly string      $url,
		public string|null          $sender = null,
		public readonly bool        $force_refresh = false,
		public readonly Height|null $height = null,
		public array                $suggestions = [],
		public int|null             $timeout = null
	)
	{
	}


	public function configure(mixed ...$parameters): void
	{
		if (array_is_list($parameters))
		{
			[$channel, $sender, $timeout] = array_pad($parameters, 3, null);

			if ($channel === Channel::RCS && (is_string($sender) || is_null($sender)) && ((is_int($timeout) && $timeout >= 60) || is_null($timeout)))
			{
				$this->sender ??= $sender;
				$this->timeout ??= $timeout ;
			}
		}
		else if (isset($parameters['channel']) && $parameters['channel'] === Channel::RCS)
		{
			$this->sender ??= isset($parameters['sender']) && is_string($parameters['sender']) ? $parameters['sender'] : $this->sender;
			$this->timeout ??= isset($parameters['timeout']) && is_int($parameters['timeout']) && $parameters['timeout'] >= 60 ? $parameters['timeout'] : $this->timeout;
		}
	}


	/**
	 * @return array{sender: string, expiration: int<60, max>, card: array<string, mixed>}
	 */
	public function jsonSerialize(): array
	{
		return [
			'sender' => $this->sender ?? '',
			'expiration' => $this->timeout ?? self::DefaultExpiration,
			'card' => (new Card(
				title: $this->title,
				description: $this->description,
				file_url: $this->url,
				file_refresh: $this->force_refresh,
				height: $this->height,
				suggestions: $this->suggestions,
			))->serialize()
		];
	}
}
