<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\{Sdk\ChannelException, Sdk\Message\Component\Viber\Variant, Sdk\Message\Settings, Sdk\Utils\Strict};
use function get_class, array_keys;

class MultiChannel extends Base
{
	use Strict;

	public string|null $primary_channel = null;

	/**
	 * @var array<string, Settings\Settings>
	 */
	public array $channels = [];


	private const ChannelMap = [
		Settings\Sms::class => Channel::SMS,

		Settings\ViberCard::class => Channel::Viber,
		Settings\ViberText::class => Channel::Viber,

		Settings\RcsText::class => Channel::RCS,
		Settings\RcsCarousel::class => Channel::RCS,
		Settings\RcsCard::class => Channel::RCS,
		Settings\RcsFile::class => Channel::RCS,

		Settings\WhatsAppMessage::class => Channel::WhatsApp,
		Settings\WhatsAppOtp::class => Channel::WhatsApp,
		Settings\WhatsAppLocation::class => Channel::WhatsApp,
		Settings\WhatsAppTemplate::class => Channel::WhatsApp,
		Settings\WhatsAppFile::class => Channel::WhatsApp
	];


	public function sms(Component\SimpleText $text, string|null $sender_id = null, string|null $sender_id_value = null, bool|null $unicode = null): self
	{
		$this->channel(new Settings\Sms($text, $sender_id, $sender_id_value, $unicode));

		return $this;
	}


	public function viber(Variant $variant = Variant::Text, mixed ...$settings): self
	{
		$this->channel($variant->createSettings(
			...$settings
		));

		return $this;
	}


	public function rcs(Component\Rcs\Variant $variant = Component\Rcs\Variant::Text, mixed ...$settings): self
	{
		$this->channel($variant->createSettings(
			...$settings,
		));

		return $this;
	}


	public function whatsapp(Component\WhatsApp\Variant $variant = Component\WhatsApp\Variant::Text, mixed ...$settings): self
	{
		$this->channel($variant->createSettings(
			...$settings,
		));

		return $this;
	}


	/**
	 * @param mixed ...$parameters
	 */
	public function configure(...$parameters): void
	{
		$channel = $parameters[0] ?? null;

		if (isset($this->channels[$channel])) {
			$this->channels[$channel]->configure(...$parameters);
		}
	}


	/**
	 * @throws ChannelException
	 */
	public function setPrimaryChannel(string $channel): self
	{
		if (!isset($this->channels[$channel])) {
			throw new ChannelException("Channel '$channel' is not defined.");
		}

		$this->primary_channel = $channel;

		return $this;
	}


	public function channel(Settings\Settings $settings): self
	{
		$class = get_class($settings);
		/** @php8 $settings::class */

		$channel = self::ChannelMap[$class] ?? null;

		if ($channel !== null) {
			$this->primary_channel ??= $channel;

			$this->channels[$channel] = $settings;
		}

		return $this;
	}


	/**
	 * @return array{primary_channel: string, phone_number: string, country: string|null, channels: array<string, Settings\Settings>}
	 */
	public function jsonSerialize(): array
	{
		return [
			'primary_channel' => $this->primary_channel ?? Channel::SMS,
			'phone_number' => (string)$this->phone_number,
			'country' => $this->phone_number->iso ?? null,
			'schedule' => $this->schedule,
			'channels' => $this->channels
		];
	}


	public function getChannels(): array
	{
		return array_keys($this->channels);
	}
}
