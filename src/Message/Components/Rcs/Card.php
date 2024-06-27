<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Rcs;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use ArrayAccess;
use BulkGate\Sdk\Message\Component\Rcs\Suggestion\Suggestion;
use function count, mb_strlen, trim;

/**
 * @implements ArrayAccess<int, Suggestion|mixed>
 */
class Card implements ArrayAccess
{
	use Suggestions;

	/**
	 * @param list<Suggestion|mixed> $suggestions
	 */
	public function __construct(
		public string|null $title = null,
		public string|null $description = null,
		public Alignment|null $alignment = null,
		public Orientation|null $orientation = null,
		public string|null $file_url = null,
		public bool $file_refresh = false,
		public Height|string|null $height = null,
		array $suggestions = [],
	)
	{
		$this->initSuggestions($suggestions);
	}


	/**
	 * @return array<string, mixed>
	 */
	public function serialize(bool $carousel = false): array
	{
		$media = [];

		$height = Height::smartHeightDetect($this->height, mb_strlen($this->title ?? '', 'UTF-8'), mb_strlen($this->description ?? '', 'UTF-8'), count($this->suggestions));

		if (empty($this->file_url) && trim($this->title . $this->description) === '' && $this->suggestions !== [])
		{
			$file_url = 'https://portal.bulkgate.com/images/choice.png';
			$height = !$carousel ? Height::Tall : $height;
		}

		$orientation = $this->orientation;
		$alignment = $this->alignment;

		if ($this->orientation instanceof Orientation)
		{
			$orientation = $this->orientation->serialize();
		}

		if ($this->alignment instanceof Alignment)
		{
			$alignment = $this->alignment->serialize();
		}

		if (($file_url ?? $this->file_url) !== null)
		{
			$media = [
				'media' => [
					'height' => $height->serialize(),
					'url' => $file_url ?? $this->file_url,
					'forceRefresh' => $this->file_refresh,
				],
			];
		}

		return [
			'title' => $this->title ?? '',
			'description' => $this->description ?? '',
			'orientation' => $orientation,
			'alignment' => $alignment,
			'suggestions' => $this->serializeSuggestions(4),
			...$media,
		];
	}
}
