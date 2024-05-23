<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\WhatsApp\Components;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;

class HeaderMedia implements Header
{
	use Strict;

	public function __construct(public readonly HeaderType $type, public readonly string $url, public readonly string $caption)
	{
	}


	public function serialize(): array
	{
		return [
			'type' => $this->type->value,
			'url' => $this->url,
			'caption' => $this->caption
		];
	}
}
