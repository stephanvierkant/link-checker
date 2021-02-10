<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::SETS, [
        SetList::CLEAN_CODE,
        SetList::COMMON,
        SetList::DOCTRINE_ANNOTATIONS,
        SetList::PSR_12,
        SetList::SYMFONY,
    ]);


    $parameters->set(Option::SKIP, [
        PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer::class,
        PhpCsFixer\Fixer\PhpUnit\PhpUnitInternalClassFixer::class,
        PhpCsFixer\Fixer\PhpUnit\PhpUnitTestClassRequiresCoversFixer::class,
        PhpCsFixer\Fixer\Semicolon\MultilineWhitespaceBeforeSemicolonsFixer::class,
        Symplify\CodingStandard\Fixer\ArrayNotation\ArrayListItemNewlineFixer::class,
        Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer::class,
        Symplify\CodingStandard\Fixer\Spacing\StandaloneLinePromotedPropertyFixer::class,
    ]);
};
