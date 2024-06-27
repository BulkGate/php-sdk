<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */


use BulkGate\Sdk\Utils\Strict;
use BulkGate\Sdk\Message\{
	Channel,
	Component\WhatsApp\Components\Body,
	Component\WhatsApp\Components\Button,
	Component\WhatsApp\Components\Header
};
use function array_pad;

class WhatsAppTemplate implements WhatsApp
{
	use Strict;

	/**
	 * @param array<Button> $buttons
	 * @param int<60, max>|null $timeout
	 */
	public function __construct(
		public Header $header,
		public Body $body,
		public array $buttons = [],
		public string|null $template = null,
		public string|null $language = 'en',
		public string|null $sender = null,
		public int|null $timeout = null,
	)
	{
	}


	public function configure(...$parameters): void
	{
		if (array_is_list($parameters))
		{
			[$channel, $sender, $timeout, $language] = array_pad($parameters, 4, null);

			if ($channel === Channel::WhatsApp && (is_string($sender) || is_null($sender)) && ((is_int($timeout) && $timeout >= 60) || is_null($timeout)) && (is_string($language) || is_null($language)))
			{
				$this->sender ??= $sender;
				$this->timeout ??= $timeout;
				$this->language ??= $language;
			}
		}
		else if (isset($parameters['channel']) && $parameters['channel'] === Channel::WhatsApp)
		{
			$this->sender ??= isset($parameters['sender']) && is_string($parameters['sender']) ? $parameters['sender'] : $this->sender;
			$this->timeout ??= isset($parameters['timeout']) && is_int($parameters['timeout']) && $parameters['timeout'] >= 60 ? $parameters['timeout'] : $this->timeout;
			$this->language ??= isset($parameters['language']) && is_string($parameters['language']) ? $parameters['language'] : $this->language;
		}
	}


	/**
	 * @return array<string|int, mixed>
	 */
	public function jsonSerialize(): array
	{
		$buttons = [];
		foreach ($this->buttons as $button)
		{
			$buttons[] = $button->serialize();
		}

		return [
			'sender' => $this->sender ?? '',
			'expiration' => $this->timeout ?? WhatsApp::DefaultExpiration,
			'template' => [
				'template' => $this->template,
				'language' => $this->language,
				'header' => $this->header->serialize(),
				'body' => $this->body->serialize(),
				'buttons' => $buttons
			]
		];
	}
}
