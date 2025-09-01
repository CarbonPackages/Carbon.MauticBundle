<?php

namespace MauticPlugin\MauticCarbonBundle;

use Mautic\ApiBundle\DependencyInjection\Compiler\SerializerPass;
use Mautic\ApiBundle\DependencyInjection\Factory\ApiFactory;
use Mautic\PluginBundle\Bundle\PluginBundleBase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class MauticCarbonBundle.
 */
class MauticCarbonBundle extends PluginBundleBase
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
    }
}
