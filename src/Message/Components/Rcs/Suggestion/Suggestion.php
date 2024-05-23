<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Rcs\Suggestion;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */
interface Suggestion
{
	/**
	 * @return array<string, mixed>
	 */
	public function serialize(): array;
}
