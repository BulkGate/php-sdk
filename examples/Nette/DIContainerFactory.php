<?php declare(strict_types=1);

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Nette\StaticClass;
use Nette\DI\{Compiler, Container as DIC, Extensions\ExtensionsExtension};

require_once __DIR__ . '/../../vendor/autoload.php';

class DIContainerFactory
{
    use StaticClass;

    /** @internal */
    public static function create(string $config_file): DIC
    {
        /** @info Please do not use this HACK in your application, it is for testing purposes only */
        eval((new Compiler)->addExtension('extensions', new ExtensionsExtension())->loadConfig($config_file)->compile());

        /** @phpstan-ignore-next-line */
        return new \Container();
    }
}

