<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Component;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;

class SmsSender
{
    use Strict;

    public const DEFAULT_SENDER = '';

    public const GATE_SYSTEM_NUMBER = 'gSystem';

    public const GATE_SHORT_CODE = 'gShort';

    public const GATE_TEXT_SENDER = 'gText';

    public const GATE_OWN_NUMBER = 'gOwn';

    public const GATE_MOBILE_CONNECT = 'gMobile';

    public const GATE_PORTAL_PROFILE = 'gProfile';

    public const GATE1 = 'gGate1';

    public const GATE2 = 'gGate2';

    public const GATE3 = 'gGate3';

    public const GATE4 = 'gGate4';

    public const GATE5 = 'gGate5';

    public const GATE6 = 'gGate6';

    public const GATE7 = 'gGate7';
}
