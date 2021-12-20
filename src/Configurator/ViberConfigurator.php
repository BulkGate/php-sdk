<?php declare(strict_types=1);

namespace BulkGate\Sdk\Configurator;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;
use BulkGate\Sdk\Message\{Base, Channel, Component\Button, Component\Image};

class ViberConfigurator implements Configurator
{
    use Strict;

    private string $sender;

    private ?Button $button = null;

    private ?Image $image = null;

    private ?int $expiration = null;


    public function __construct(string $sender)
    {
        $this->sender = $sender;
    }


    public function button(string $caption, string $url): void
    {
        $this->button = new Button($caption, $url);
    }


    public function image(string $url, bool $zoom = false): void
    {
        $this->image = new Image($url, $zoom);
    }


    public function expiration(?int $expiration): void
    {
        $this->expiration = $expiration;
    }


    public function configure(Base $message): void
    {
        $message->configure(Channel::VIBER, $this->sender, $this->button, $this->image, $this->expiration);
    }


    public function getChannel(): string
    {
        return Channel::VIBER;
    }
}
