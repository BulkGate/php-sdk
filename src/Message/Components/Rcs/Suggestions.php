<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Rcs;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use function array_map, array_key_exists, array_slice;

trait Suggestions
{
	/**
	 * @var list<Suggestion\Suggestion>
	 */
	public array $suggestions = [];

	/**
	 * @param array<array-key, Suggestion\Suggestion|mixed> $list
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
	 * @return list<mixed>
	 */
	public function serializeSuggestions(int|null $limit = null): array
	{
		return array_map(fn(Suggestion\Suggestion $suggestion): array => $suggestion->serialize(), $limit !== null ? array_slice($this->suggestions, 0, $limit) : $this->suggestions);
	}


	public function offsetExists(mixed $offset): bool
	{
		return array_key_exists($offset, $this->suggestions);
	}


	public function offsetGet(mixed $offset): Suggestion\Suggestion|null
	{
		return $this->suggestions[$offset] ?? null;
	}


	public function offsetSet(mixed $offset, mixed $value): void
	{
		if ($value instanceof Suggestion\Suggestion)
		{
			$this->suggestions[] = $value;
		}
	}


	public function offsetUnset(mixed $offset): void
	{
		unset($this->suggestions[$offset]);
	}
}
