<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{Utils\Strict, Message\Channel};
use function array_pad;

class WhatsAppMessage implements WhatsApp
{
	use Strict;

	/**
	 * @param int<60, max>|null $timeout
	 */
	public function __construct(
		public string|null $sender = null,
		public string $text = '',
		public int|null $timeout = null,
		public bool|null $preview_url = true,
	)
	{
	}


	public function configure(...$parameters): void
	{
		if (array_is_list($parameters))
		{
			[$channel, $sender, $timeout, $preview_url] = array_pad($parameters, 4, null);

			if ($channel === Channel::WhatsApp && (is_string($sender) || is_null($sender)) && ((is_int($timeout) && $timeout >= 60) || is_null($timeout)) && (is_null($preview_url) || (is_bool($preview_url))))
			{
				$this->sender ??= $sender;
				$this->timeout ??= $timeout;
				$this->preview_url ??= $preview_url;
			}
		}
		else if (isset($parameters['channel']) && $parameters['channel'] === Channel::WhatsApp)
		{
			$this->sender ??= isset($parameters['sender']) && is_string($parameters['sender']) ? $parameters['sender'] : $this->sender;
			$this->timeout ??= isset($parameters['timeout']) && is_int($parameters['timeout']) && $parameters['timeout'] >= 60 ? $parameters['timeout'] : $this->timeout;
			$this->preview_url ??= isset($parameters['preview_url']) && is_bool($parameters['preview_url']) ? $parameters['preview_url'] : $this->preview_url;
		}
	}


	/**
	 * @return array{sender: string, expiration: int<60, max>, message: array{text: string, preview_url: bool}}
	 */
	public function jsonSerialize(): array
	{
		return [
			'sender' => $this->sender ?? '',
			'expiration' => $this->timeout ?? self::DefaultExpiration,
			'message' => [
				'text' => $this->text,
				'preview_url' => $this->preview_url ?? false,
			]
		];
	}
}
