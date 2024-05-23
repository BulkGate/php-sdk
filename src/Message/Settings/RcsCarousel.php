<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;
use BulkGate\Sdk\Message\{Channel, Component\Rcs\Card, Component\Rcs\Width};
use function array_pad;

class RcsCarousel implements Rcs
{
	use Strict;

	/**
	 * @param array<Card> $cards
	 * @param int<60, max>|null $timeout
	 */
	public function __construct(
		public string|null         $sender = null,
		public readonly array      $cards = [],
		public readonly Width|null $width = null,
		public int|null            $timeout = null
	)
	{
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
	 * @return array{sender: string, expiration: int<60, max>, carousel: array{width: string|null, cards: array<int<0, max>, array<string, mixed>>}}
	 */
	public function jsonSerialize(): array
	{
		$cards = [];
		foreach ($this->cards as $card)
		{
			$cards[] = $card->serialize();
		}

		if ($this->width instanceof Width)
		{
			$width = $this->width->serialize();
		}
		else
		{
			$width = $this->width ?? null;
		}

		return [
			'sender' => $this->sender ?? '',
			'expiration' => $this->timeout ?? self::DefaultExpiration,
			'carousel' => [
				'width' => $width,
				'cards' => $cards
			]
		];
	}
}
