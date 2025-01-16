<?php

namespace IDCI\Bundle\SAMClientBundle;

use IDCI\Bundle\SAMClientBundle\DependencyInjection\Compiler\CachePoolInjectionCompilerPass;
use IDCI\Bundle\SAMClientBundle\DependencyInjection\Compiler\EightPointsGuzzleClientInjectionCompilerPass;
use IDCI\Bundle\SAMClientBundle\DependencyInjection\IDCISAMClientExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class IDCISAMClientBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new IDCISAMClientExtension();
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container
            ->addCompilerPass(new EightPointsGuzzleClientInjectionCompilerPass())
            ->addCompilerPass(new CachePoolInjectionCompilerPass())
        ;
    }
}
