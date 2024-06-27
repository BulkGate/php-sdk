<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Rcs\Suggestion;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\InvalidStateException;
use BulkGate\Sdk\Message\Component\Rcs\SuggestionType;

class ViewLocation extends Action
{
	public function __construct(
		string $text,
		string $postback = 'ok',
		public string|float|null $latitude = null,
		public string|float|null $longitude = null,
		public string|null $query = null,
		public string|null $label = null,
	)
	{
		parent::__construct(
			type: SuggestionType::ViewLocation,
			text: $text,
			postback: $postback,
		);
	}


	public function serialize(mixed ...$parameters): array
	{
		if ($this->latitude !== null && $this->longitude !== null)
		{
			return parent::serialize(
				location: [
					'latitude' => "$this->latitude",
					'longitude' => "$this->longitude",
					'label' => $this->label,
				],
			);
		}
		else if (!empty($this->query))
		{
			return parent::serialize(
				location: [
					'query' => $this->query,
					'label' => $this->label,
				],
			);
		}
		else
		{
			throw new InvalidStateException('view_location_action_missing_location');
		}
	}
}
