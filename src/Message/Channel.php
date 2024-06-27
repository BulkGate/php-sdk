<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */
enum Channel
{
	public const SMS = 'sms';

	public const Viber = 'viber';

	public const RCS = 'rcs';

	public const WhatsApp = 'whatsapp';
}
