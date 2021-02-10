<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::ENABLE_CACHE, true);

    $parameters->set(Option::SETS, [
        SetList::CODE_QUALITY,
        SetList::CONTRIBUTTE_TO_SYMFONY,
        SetList::DOCTRINE_CODE_QUALITY,
        SetList::DOCTRINE_DBAL_30,
        SetList::PHP_73,
        SetList::PHP_74,
        SetList::PHP_80,
        SetList::PRIVATIZATION,
        SetList::SYMFONY_50_TYPES,
        SetList::SYMFONY_50,
        SetList::SYMFONY_CODE_QUALITY,
        SetList::TYPE_DECLARATION,
    ]);
};
