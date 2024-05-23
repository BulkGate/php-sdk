<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Marek Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{Utils\Strict, Message\Component\Rcs\Variant};

class Rcs extends Base
{
	use Strict;

	public Component\PhoneNumber $phone_number;

	public Settings\Rcs $settings;


	/**
	 * @param Component\PhoneNumber|string $phone_number
	 */
	public function __construct(Component\PhoneNumber|string $phone_number, Variant $variant = Variant::Text, mixed ...$settings)
	{
		parent::__construct($phone_number);

		$this->settings = $variant->createSettings(...$settings);
	}


	public function configure(...$parameters): void
	{
		$this->settings->configure(...$parameters);
	}


	/**
	 * @return array<string, mixed>
	 */
	public function jsonSerialize(): array
	{
		return [
			'primary_channel' => Channel::RCS,
			'number' => (string)$this->phone_number,
			'country' => $this->phone_number->iso,
			'schedule' => $this->schedule,
			'channels' => [
				Channel::RCS => $this->settings
			]
		];
	}


	public function getChannels(): array
	{
		return [Channel::RCS];
	}
}
