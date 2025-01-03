<?php

namespace IDCI\Bundle\SAMClientBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class IDCISAMClientExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('services.yaml');

        $container->setParameter(sprintf('%s.client_secret', Configuration::CONFIGURATION_ROOT), $config['client_secret']);
        $container->setParameter(sprintf('%s.client_id', Configuration::CONFIGURATION_ROOT), $config['client_id']);
        $container->setParameter(sprintf('%s.mode', Configuration::CONFIGURATION_ROOT), $config['mode']);
    }

    public function getAlias(): string
    {
        return Configuration::CONFIGURATION_ROOT;
    }
}
