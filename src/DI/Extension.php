<?php declare(strict_types=1);

namespace BulkGate\Sdk\DI;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use stdClass;
use Nette\{DI\CompilerExtension, Schema\Expect, Schema\Schema};
use BulkGate\Sdk\{Configurator\SmsConfigurator, Configurator\SmsCountryConfigurator, Configurator\ViberConfigurator, Connection\Connection, Connection\ConnectionStream, CreditChecker, Message\Component\SmsSender, MessageSender, NumberChecker, Sender};
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
                ]),
                'viber' => Expect::structure([
                    'sender' => Expect::string()->required(),
                    'button' => Expect::structure([
                        'caption' => Expect::string('OK'),
                        'url' => Expect::string()->required()
                    ])->required(false),
                    'image' => Expect::structure([
                        'url' => Expect::string()->required(),
                        'zoom' => Expect::bool(false)
                    ])->required(false),
                    'expiration' => Expect::int()
                ])->required(false)
            ])
        ]);
    }


    public function loadConfiguration(): void
    {
        $builder = $this->getContainerBuilder();

        $sms = $this->config->configurator->sms;

        if (count($sms->country) > 0)
        {
            $configurator = $builder->addDefinition($this->prefix('configurator.sms'))
                ->setFactory(SmsCountryConfigurator::class, [$sms->unicode]);

            foreach ($sms->country as $country => $item)
            {
                $configurator->addSetup('addCountry', [$country, $item->gate, $item->sender]);
            }
        }
        else
        {
            $builder->addDefinition($this->prefix('configurator.sms'))
                ->setFactory(SmsConfigurator::class, [$sms->sender_id, $sms->sender_id_value, $sms->unicode]);
        }

        $viber = $this->config->configurator->viber;

        if ($viber !== null)
        {
            $viber_configurator = $builder->addDefinition($this->prefix('configurator.viber'))
                ->setFactory(ViberConfigurator::class, [$viber->sender]);

            if ($viber->button)
            {
                $viber_configurator->addSetup('button', [$viber->button->caption, $viber->button->url]);
            }

            if ($viber->image)
            {
                $viber_configurator->addSetup('image', [$viber->image->url, $viber->image->zoom]);
            }

            if ($viber->expiration)
            {
                $viber_configurator->addSetup('expiration', [$viber->expiration]);
            }
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

        $sender = $builder->addDefinition($this->prefix('sender'))
            ->setAutowired(Sender::class)
            ->setFactory(MessageSender::class)
            ->addSetup('setTag', [$this->config->sender->tag])
            ->addSetup('setDefaultCountry', [$this->config->sender->default_country])
            ->addSetup('addSenderConfigurator', ['@' . $this->prefix('configurator.sms')]);

        if ($viber !== null)
        {
            $sender->addSetup('addSenderConfigurator', ['@' . $this->prefix('configurator.viber')]);
        }

        $builder->addDefinition($this->prefix('number.checker'))
            ->setFactory(NumberChecker::class);

        $builder->addDefinition($this->prefix('credit.checker'))
            ->setFactory(CreditChecker::class);
    }
}
