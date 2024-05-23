<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\WhatsApp\Components;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */
interface Button
{
	/**
	 * @return array<array-key, mixed>
	 */
	public function serialize(): array;
}
