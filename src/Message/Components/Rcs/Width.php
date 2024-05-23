<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Rcs;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use function strtoupper;

enum Width: string
{
	case Small = 'small';
	case Medium = 'medium';

	public function serialize(): string
	{
		return strtoupper($this->value);
	}
}
