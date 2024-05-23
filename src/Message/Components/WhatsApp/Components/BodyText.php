<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\WhatsApp\Components;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;

class BodyText implements Body
{
	use Strict;

	public function __construct(public readonly BodyType $type, public readonly string $text)
	{
	}


	public function serialize(): array
	{
		return [
			'type' => $this->type->value,
			'text' => $this->text
		];
	}
}
