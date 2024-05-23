<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Rcs\Suggestion;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Message\Component\Rcs\SuggestionType;

class ShareLocation extends Action
{
	public function __construct(public string $text, public string $postback = 'ok')
	{
		parent::__construct(
			type: SuggestionType::ShareLocation,
			text: $text,
			postback: $postback,
		);
	}


	public function serialize(mixed ...$parameters): array
	{
		return parent::serialize();
	}
}
