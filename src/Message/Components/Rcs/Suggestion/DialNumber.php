<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Rcs\Suggestion;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;
use BulkGate\Sdk\Message\Component\{PhoneNumber, Rcs\SuggestionType};

class DialNumber extends Action
{
	use Strict;

	public function __construct(public readonly string $phone_number, public string $text, string $postback = 'ok')
	{
		parent::__construct(
			type: SuggestionType::DialNumber,
			text: $text,
			postback: $postback,
		);
	}


	public function serialize(mixed ...$parameters): array
	{
		return parent::serialize(
			phoneNumber: '+' . PhoneNumber::formatNumber($this->phone_number)
		);
	}
}
