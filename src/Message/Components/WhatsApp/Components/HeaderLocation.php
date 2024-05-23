<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\WhatsApp\Components;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;

class HeaderLocation implements Header
{
	use Strict;

	public function __construct(public readonly HeaderType $type, public readonly float $latitude, public readonly float $longitude, public readonly string $name, public readonly string $address)
	{
	}


	public function serialize(): array
	{
		return [
			'type' => $this->type->value,
			'location' => [
				'latitude' => $this->latitude,
				'longitude' => $this->longitude,
				'name' => $this->name,
				'address' => $this->address
			],
		];
	}
}
