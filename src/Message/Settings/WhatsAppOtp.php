<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Settings;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{Utils\Strict, Message\Channel};
use function array_pad;

class WhatsAppOtp implements WhatsApp
{
	use Strict;

	/**
	 * @param int<60, max>|null $timeout
	 */
	public function __construct(
		public string|null $sender = null,
		public string      $template = 'verification_code',
		public string      $code = '',
		public string      $language = 'en',
		public int|null    $timeout = null,
	)
	{
	}


	public function configure(...$parameters): void
	{
		if (array_is_list($parameters))
		{
			[$channel, $sender, $timeout] = array_pad($parameters, 3, null);

			if ($channel === Channel::whatsApp && (is_string($sender) || is_null($sender)) && ((is_int($timeout) && $timeout >= 60) || is_null($timeout)))
			{
				$this->sender ??= $sender;
				$this->timeout ??= $timeout;
			}
		}
		else if (isset($parameters['channel']) && $parameters['channel'] === Channel::whatsApp)
		{
			$this->sender ??= isset($parameters['sender']) && is_string($parameters['sender']) ? $parameters['sender'] : $this->sender;
			$this->timeout ??= isset($parameters['timeout']) && is_int($parameters['timeout']) && $parameters['timeout'] >= 60 ? $parameters['timeout'] : $this->timeout;
		}
	}


	/**
	 * @return array{sender: string, expiration: int<60, max>, otp: array{template: string, code: string, language: string}}
	 */
	public function jsonSerialize(): array
	{
		return [
			'sender' => $this->sender ?? '',
			'expiration' => $this->timeout ?? WhatsApp::DefaultExpiration,
			'otp' => [
				'template' => $this->template,
				'code' => $this->code,
				'language' => $this->language,
			]
		];
	}
}
