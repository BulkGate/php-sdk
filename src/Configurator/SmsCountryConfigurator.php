<?php declare(strict_types=1);

namespace BulkGate\Sdk\Configurator;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Utils\Strict;
use BulkGate\Sdk\Message\{Channel, Component\SmsSender, Base};
use function mb_strtolower, preg_match;

class SmsCountryConfigurator implements Configurator
{
    use Strict;

    private const PrefixRegex = '~^(1|7|20|27|30|31|32|33|34|36|39|40|41|43|44|45|46|47|48|49|51|52|53|54|55|56|57|58|60|61|62|63|64|65|66|81|82|84|86|90|91|92|93|94|95|98|211|212|213|216|218|220|221|222|223|224|225|226|227|228|229|230|231|232|233|234|235|236|237|238|239|240|241|242|243|244|245|248|249|250|251|252|253|254|255|256|257|258|260|261|262|263|264|265|266|267|268|269|291|297|298|299|350|351|352|353|354|355|356|357|358|359|370|371|372|373|374|375|376|377|378|380|381|382|383|385|386|387|389|420|421|423|500|501|502|503|504|505|506|507|508|509|590|591|592|593|594|595|596|597|598|599|673|674|675|676|677|678|679|680|682|685|686|687|688|689|852|853|855|856|880|886|960|961|962|963|964|965|966|967|968|971|972|973|974|975|976|977|992|993|994|995|996|998).*~sD';

    private bool $unicode;

    /**
     * @var array<string, array<string>>
     */
    protected array $profile = [];


    public function __construct(bool $unicode = false)
    {
        $this->unicode = $unicode;
    }


    public function unicode(bool $enabled = true): void
    {
        $this->unicode = $enabled;
    }


    public function addCountry(string $iso, string $gate = SmsSender::GATE1, string $sender = SmsSender::DEFAULT_SENDER): self
    {
        $this->profile[mb_strtolower($iso)] = [$gate, $sender];

        return $this;
    }


    public function removeCountry(string $iso): void
    {
        unset($this->profile[mb_strtolower($iso)]);
    }


    public function configure(Base $message): void
    {
        if (preg_match(self::PrefixRegex, $message->phone_number->phone_number, $match))
        {
            [, $prefix] = $match;

            $iso = PrefixMap::PREFIX_TO_ISO[$prefix] ?? null;

            if ($iso !== null && isset($this->profile[$iso]))
            {
                [$sender_id, $sender_id_value] = $this->profile[$iso];
            }

            $message->configure(Channel::SMS, $sender_id ?? SmsSender::GATE1, $sender_id_value ?? SmsSender::DEFAULT_SENDER, $this->unicode);
        }
    }


    public function getChannel(): string
    {
        return Channel::SMS;
    }
}
