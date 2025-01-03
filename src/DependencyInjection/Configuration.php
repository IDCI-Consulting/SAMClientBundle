<?php

namespace IDCI\Bundle\SAMClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public const CONFIGURATION_ROOT = 'idci_sam_client';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(self::CONFIGURATION_ROOT);

        $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}
