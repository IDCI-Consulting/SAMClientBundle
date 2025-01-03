<?php

namespace IDCI\Bundle\SAMClientBundle;

use IDCI\Bundle\SAMClientBundle\DependencyInjection\IDCISAMClientExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class IDCISAMClientBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new IDCISAMClientExtension();
    }
}