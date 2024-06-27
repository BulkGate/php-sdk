<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;
use BulkGate\Sdk\Message\Component\{PhoneNumber, SimpleText, Viber\Variant};

class Viber extends Base
{
	use Strict;

	public Settings\Viber $settings;


	/**
	 * @param PhoneNumber|string $phone_number
	 * @param SimpleText|string|null $text
	 * @param array<string, mixed> $variables
	 * @param Variant $variant
	 * @param mixed ...$settings
	 */
	public function __construct(
		PhoneNumber|string $phone_number,
		SimpleText|string|null $text = null,
		array $variables = [],
		Variant $variant = Variant::Text,
		mixed ...$settings
	)
	{
		parent::__construct($phone_number);

		$settings['text'] = Helpers::createText($text, $variables) ?? new SimpleText();

		$this->settings = $variant->createSettings(...$settings);
	}


	/**
	 * @param array<string, string|int|float> $variables
	 */
	public function text(string $text, array $variables = []): self
	{
		$this->settings->getText()?->text($text, $variables);

		return $this;
	}


	public function configure(...$parameters): void
	{
		$this->settings->configure(...$parameters);
	}


	/**
	 * @return array{primary_channel: string, phone_number: string, country: string|null, channels: array<string, Settings\Viber>}
	 */
	public function jsonSerialize(): array
	{
		return [
			'primary_channel' => Channel::Viber,
			'phone_number' => (string)$this->phone_number,
			'country' => $this->phone_number->iso ?? null,
			'schedule' => $this->schedule,
			'channels' => [
				Channel::Viber => $this->settings
			]
		];
	}


	public function getChannels(): array
	{
		return [Channel::Viber];
	}
}
