<?php declare(strict_types=1);

namespace BulkGate\Sdk\DI;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use stdClass;
use Nette\DI\CompilerExtension;
use Nette\Schema\{Expect, Schema};
use BulkGate\Sdk\{
    Configurator\SmsConfigurator,
    Configurator\SmsCountryConfigurator,
    Connection\Connection,
    Connection\ConnectionStream,
    Message\Component\SmsSender,
    MessageSender,
    NumberChecker,
    Sender
};
use function count;

/**
 * @property stdClass $config
 */
class Extension extends CompilerExtension
{
    public function getConfigSchema(): Schema
    {
        return Expect::structure([
            'application_id' => Expect::int()->required(),
            'application_token' => Expect::string()->required(),
            'application_product' => Expect::string('nette'),
            'connection' => Expect::structure([
                'api' => Expect::string('https://portal.bulkgate.com/api/1.0/integration'),
                'content_type' => Expect::string('application/json')
            ]),
            'sender' => Expect::structure([
                'tag' => Expect::string(''),
                'default_country' => Expect::string()->nullable()
            ]),
            'configurator' => Expect::structure([
                'sms' => Expect::structure([
                    'sender_id' => Expect::string(SmsSender::GATE_SYSTEM_NUMBER),
                    'sender_id_value' => Expect::string(SmsSender::GATE_SYSTEM_NUMBER),
                    'unicode' => Expect::bool(false),
                    'country' => Expect::arrayOf(Expect::structure([
                        'gate' => Expect::string(),
                        'sender' => Expect::string()
                    ]))
                ])
            ])
        ]);
    }


    public function loadConfiguration(): void
    {
        $builder = $this->getContainerBuilder();

        $sms = $this->config->configurator->sms;

        if (count($sms->country) > 0)
        {
            $configurator = $builder->addDefinition($this->prefix('sms.configurator'))
                ->setFactory(SmsCountryConfigurator::class);

            foreach ($sms->country as $country => $item)
            {
                $configurator->addSetup('addCountry', [$country, $item->gate, $item->sender]);
            }
        }
        else
        {
            $builder->addDefinition($this->prefix('sms.configurator'))
                ->setFactory(SmsConfigurator::class, [$sms->sender_id, $sms->sender_id_value, $sms->unicode]);
        }

        $builder->addDefinition($this->prefix('connection'))
            ->setAutowired(Connection::class)
            ->setFactory(ConnectionStream::class, [
                $this->config->application_id,
                $this->config->application_token,
                $this->config->connection->api,
                $this->config->application_product,
                $this->config->connection->content_type
            ]);

        $builder->addDefinition($this->prefix('sender'))
            ->setAutowired(Sender::class)
            ->setFactory(MessageSender::class)
            ->addSetup('setTag', [$this->config->sender->tag])
            ->addSetup('setDefaultCountry', [$this->config->sender->default_country])
            ->addSetup('addSenderConfigurator', ['@' . $this->prefix('sms.configurator')]);

        $builder->addDefinition($this->prefix('number.checker'))
            ->setFactory(NumberChecker::class);
    }
}
