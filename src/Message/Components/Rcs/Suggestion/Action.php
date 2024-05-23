<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Rcs\Suggestion;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Message\Component\Rcs\{Helpers, SuggestionType};

abstract class Action implements Suggestion
{
	public function __construct(public SuggestionType $type, public string $text, public string $postback)
	{
	}


	/**
	 * @param mixed ...$parameters
	 * @return array<string|int, mixed>
	 */
	public function serialize(mixed ...$parameters): array
	{
		return [
			'type' => $this->type->value,
			'text' => Helpers::sanitizeSuggestionTitle($this->text),
			'postback' => $this->postback,
			...$parameters
		];
	}
}
