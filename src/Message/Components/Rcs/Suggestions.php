<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Rcs;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Message\Component\Rcs\Suggestion\Suggestion;
use function array_map, array_key_exists, array_slice;

trait Suggestions
{
	/**
	 * @var list<Suggestion|mixed>|array<int<0, max>, mixed>
	 */
	public array $suggestions = [];

	/**
	 * @param list<Suggestion|mixed>|array<int<0, max>, mixed> $list
	 * @return void
	 */
	protected function initSuggestions(array $list): void
	{
		foreach ($list as $item)
		{
			$this->suggestions[] = $item;
		}
	}


	/**
	 * @return array<int, mixed>
	 */
	public function serializeSuggestions(int|null $limit = null): array
	{
		return array_map(fn(Suggestion $suggestion): array => $suggestion->serialize(), $limit !== null ? array_slice($this->suggestions, 0, $limit) : $this->suggestions);
	}


	public function offsetExists(mixed $offset): bool
	{
		return array_key_exists($offset, $this->suggestions);
	}


	public function offsetGet(mixed $offset): Suggestion|null
	{
		return $this->suggestions[$offset] ?? null;
	}


	public function offsetSet(mixed $offset, mixed $value): void
	{
		if ($value instanceof Suggestion)
		{
			$this->suggestions[] = $value;
		}
	}


	public function offsetUnset(mixed $offset): void
	{
		unset($this->suggestions[$offset]);
	}
}
