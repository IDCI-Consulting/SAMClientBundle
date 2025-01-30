<?php

namespace IDCI\Bundle\SAMClientBundle\DependencyInjection\Compiler;

use IDCI\Bundle\SAMClientBundle\Client\SAMApiClient;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EightPointsGuzzleClientInjectionCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $guzzleHttpClientServiceAlias = $container->getParameter('idci_sam_client.guzzle_http_client_service_alias');

        $httpClientDefinition = $container->findDefinition($guzzleHttpClientServiceAlias);
        $samClientDefinition = $container->findDefinition(SAMApiClient::class);
        $samClientDefinition->addMethodCall('setHttpClient', [$httpClientDefinition]);
    }
}
