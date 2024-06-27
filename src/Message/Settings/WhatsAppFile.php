<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{Utils\Strict, Message\Channel, Message\Component\WhatsApp\Components\FileType};
use function array_pad;

class WhatsAppFile implements WhatsApp
{
	use Strict;

	/**
	 * @param int<60, max>|null $timeout
	 */
	public function __construct(
		public string|null $sender = null,
		public FileType $type = FileType::Image,
		public string $url = '',
		public string|null $caption = null,
		public int|null $timeout = null,
	)
	{
	}


	public function configure(...$parameters): void
	{
		/*if (array_is_list($parameters))
		{
			[$channel, $sender, $timeout] = array_pad($parameters, 3, null);

			if ($channel === Channel::WhatsApp && (is_string($sender) || is_null($sender)) && ((is_int($timeout) && $timeout >= 60) || is_null($timeout)))
			{
				$this->sender ??= $sender;
				$this->timeout ??= $timeout;
			}
		}
		else if (isset($parameters['channel']) && $parameters['channel'] === Channel::WhatsApp)
		{
			$this->sender ??= isset($parameters['sender']) && is_string($parameters['sender']) ? $parameters['sender'] : $this->sender;
			$this->timeout ??= isset($parameters['timeout']) && is_int($parameters['timeout']) && $parameters['timeout'] >= 60 ? $parameters['timeout'] : $this->timeout;
		}*/

		[$this->sender, $this->timeout] = Helpers::configureGeneral($this->sender, $this->timeout, ...$parameters);
	}


	/**
	 * @return array{sender: string, expiration: int<60, max>, file: array{type: string, url: string, caption: string|null}}
	 */
	public function jsonSerialize(): array
	{
		return [
			'sender' => $this->sender ?? '',
			'expiration' => $this->timeout ?? self::DefaultExpiration,
			'file' => [
				'type' => $this->type->serialize(),
				'url' => $this->url,
				'caption' => $this->caption,
			]
		];
	}
}
