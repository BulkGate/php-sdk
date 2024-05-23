<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Rcs;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use function is_string, strtoupper;

enum Height: string
{
	case Short = 'short';
	case Medium = 'medium';
	case Tall = 'tall';

	/**
	 * @param int<0, max> $title_length
	 * @param int<0, max> $description_length
	 * @param int<0, max> $suggestions_count
	 */
	public static function smartHeightDetect(Height|string|null $height, int $title_length, int $description_length, int $suggestions_count): Height
	{
		if ($height === null)
		{
			if (($title_length + $description_length) <= 20 && $suggestions_count === 0)
			{
				return self::Tall;
			}
			else if ($suggestions_count === 1 || (($title_length + $description_length) <= 50 && $suggestions_count === 0))
			{
				return self::Medium;
			}
			else
			{
				return self::Short;
			}
		}
		else if (is_string($height))
		{
			return Height::tryFrom($height) ?? self::smartHeightDetect(null, $title_length, $description_length, $suggestions_count);
		}
		else
		{
			return $height;
		}
	}


	public function serialize(): string
	{
		return strtoupper($this->value);
	}
}
