<?php declare(strict_types=1);

namespace BulkGate\Sdk\Utils;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use ArrayAccess, ArrayIterator, Countable, IteratorAggregate, JsonSerializable;
use BulkGate\Sdk\Message\Base;
use function array_values, count;

/**
 * @implements IteratorAggregate<array-key, Base>
 * @implements ArrayAccess<array-key, Base|mixed>
 */
abstract class Iterator implements ArrayAccess, IteratorAggregate, Countable, JsonSerializable
{
    use Strict;

    /**
     * @var array<array-key, mixed>
     */
    protected array $list = [];


    public function offsetExists(mixed $offset): bool
    {
        return isset($this->list[$offset]);
    }


    /**
     * @param array-key $offset
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset): mixed
    {
        return $this->list[$offset] ?? null;
    }


    /**
     * @param array-key|null $offset
     */
    public function offsetSet($offset, mixed $value): void
    {
        $offset === null ? $this->list[] = $value : $this->list[$offset] = $value;
    }


    /**
     * @param array-key $offset
     */
    public function offsetUnset($offset): void
    {
        unset($this->list[$offset]);
    }


    /**
     * @return ArrayIterator<int|string, mixed>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->list);
    }


    public function count(): int
    {
        return count($this->list);
    }


    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return array_values($this->list);
    }
}
