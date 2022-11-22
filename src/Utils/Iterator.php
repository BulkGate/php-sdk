<?php declare(strict_types=1);

namespace BulkGate\Sdk\Utils;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use ArrayAccess, ArrayIterator, Countable, IteratorAggregate, JsonSerializable;
use BulkGate\Sdk\Message\Base;
use function array_values, count;

/**
 * @implements IteratorAggregate<array-key, Base>
 * @implements ArrayAccess<array-key, Base>
 */
abstract class Iterator implements ArrayAccess, IteratorAggregate, Countable, JsonSerializable
{
    use Strict;

    /**
     * @var array<array-key, mixed>
     */
    protected array $list = [];


    /**
     * @param mixed $offset
     */
    public function offsetExists($offset): bool
    {
        return isset($this->list[$offset]);
    }


    /**
     * @param array-key $offset
     * @return mixed|null
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->list[$offset] ?? null;
    }


    /**
     * @param array-key|null $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
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
