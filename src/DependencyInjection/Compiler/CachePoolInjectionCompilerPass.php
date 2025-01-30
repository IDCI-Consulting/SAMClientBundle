<?php

namespace IDCI\Bundle\SAMClientBundle\DependencyInjection\Compiler;

use IDCI\Bundle\SAMClientBundle\Client\SAMApiClient;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CachePoolInjectionCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $cachePoolServiceAlias = $container->getParameter('idci_sam_client.cache_pool_service_alias');

        if (null !== $cachePoolServiceAlias) {
            $cachePoolDefinition = $container->findDefinition($cachePoolServiceAlias);
            $samClientDefinition = $container->findDefinition(SAMApiClient::class);
            $samClientDefinition->addMethodCall('setCache', [$cachePoolDefinition]);
        }
    }
}
