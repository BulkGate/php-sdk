<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\WhatsApp\Components;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */
class ButtonUrlParameter implements Button
{
	public function __construct(public int $index, public string $text)
	{
	}


	public function serialize(): array
	{
		return [
			'type' => 'url',
			'index' => $this->index,
			'text' => $this->text
		];
	}
}
