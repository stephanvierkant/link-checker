<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('monolog', [
        'handlers' => [
            'cli' => [
                'type' => 'console',
                'level' => 'info',
                'bubble' => true,
                'include_extra' => true,
                'channels' => [
                    'app',
                ],
            ],
        ],
    ]);
};
