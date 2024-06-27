<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component\Rcs\Suggestion;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use DateTimeZone;
use BulkGate\Sdk\Message\Component\{Helpers, Rcs\SuggestionType};

class CreateCalendarEvent extends Action
{
	public \DateTime $start;

	public \DateTime $end;

	public function __construct(
		\DateTime|string|int|null $start,
		\DateTime|string|int|null $end,
		public string $text,
		public string $postback = 'ok',
		public string|null $title = null,
		public string|null $description = null,
		public string|null $fallback_url = null,
		public string $timezone = 'Europe/London'
	)
	{
		$this->start = Helpers::createDateTime($start, $timezone) ?? (new \DateTime('now'))->setTimezone(new DateTimeZone('UTC'));

		$dolly = clone $this->start;
		$this->end = Helpers::createDateTime($end, $timezone) ?? $dolly->modify('+1 hour')->setTimezone(new DateTimeZone('UTC'));

		parent::__construct(
			type: SuggestionType::CreateCalendarEvent,
			text: $text,
			postback: $postback,
		);
	}


	public function serialize(mixed ...$parameters): array
	{
		return parent::serialize(
			calendar: [
				'start' => $this->start->format('Y-m-d\TH:i:sp'),
				'end' => $this->end->format('Y-m-d\TH:i:sp'),
				'title' => $this->title ?? $this->text,
				'description' => $this->description,
				'timezone' => $this->timezone
			]
		);
	}
}
