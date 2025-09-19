<?php

declare(strict_types=1);

use Mautic\CoreBundle\DependencyInjection\MauticCoreExtension;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $configurator) {
    $services = $configurator->services()->defaults()->autowire()->autoconfigure()->public();

    $excludes = [];

    $services
        ->load('MauticPlugin\\MauticCarbonBundle\\', '../')
        ->exclude('../{' . implode(',', array_merge(MauticCoreExtension::DEFAULT_EXCLUDES, $excludes)) . '}');

    $services
        ->load('MauticPlugin\\MauticCarbonBundle\\Entity\\', '../Entity/*Repository.php')
        ->tag(
            Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\ServiceRepositoryCompilerPass::REPOSITORY_SERVICE_TAG
        );

    $services->alias(
        'mautic.emailConfig.model.emailConfig',
        'MauticPlugin\\MauticCarbonBundle\\Model\\EmailConfigModel'
    );
};
