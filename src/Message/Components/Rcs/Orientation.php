<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Rcs;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use function is_string;

enum Orientation: string
{
	case Vertical = 'vertical';
	case Horizontal = 'horizontal';

	/**
	 * @param int<0, max> $title_length
	 * @param int<0, max> $description_length
	 * @param int<0, max> $suggestions_count
	 */
	public static function smartOrientationDetect(Orientation|string|null $orientation, int $title_length, int $description_length, int $suggestions_count): Orientation
	{
		if ($title_length + $description_length + $suggestions_count === 0)
		{
			return Orientation::Vertical;
		}

		if ($orientation === null)
		{
			return self::Vertical;
		}
		else if (is_string($orientation))
		{
			return Orientation::tryFrom($orientation) ?? self::Vertical;
		}
		else
		{
			return $orientation;
		}
	}


	public function serialize(): string
	{
		return strtoupper($this->value);
	}
}
