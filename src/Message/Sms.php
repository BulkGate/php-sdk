<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\{Sdk\Message\Component\SimpleText, Sdk\Utils\Strict};

class Sms extends Base
{
	use Strict;

	public Settings\Sms $settings;

	/**
	 * @param Component\PhoneNumber|string $phone_number
	 * @param Component\SimpleText|string|null $text
	 */
	public function __construct(Component\PhoneNumber|string $phone_number, Component\SimpleText|string|null $text = null)
	{
		parent::__construct($phone_number);
		$this->settings = new Settings\Sms(Helpers::createText($text) ?? new SimpleText());
	}


	/**
	 * @param array<string, string|int|float> $variables
	 */
	public function text(string $text, array $variables = []): self
	{
		$this->settings->text->text($text, $variables);

		return $this;
	}


	public function configure(...$parameters): void
	{
		$this->settings->configure(...$parameters);
		$this->settings->configure(sender_id: 'gText');
	}


	/**
	 * @return array{primary_channel: string, phone_number: string, country: string|null, channels: array<string, Settings\Sms>}
	 */
	public function jsonSerialize(): array
	{
		return [
			'primary_channel' => Channel::SMS,
			'phone_number' => (string)$this->phone_number,
			'country' => $this->phone_number->iso ?? null,
			'schedule' => $this->schedule,
			'channels' => [
				Channel::SMS => $this->settings
			]
		];
	}


	public function getChannels(): array
	{
		return [Channel::SMS];
	}
}
