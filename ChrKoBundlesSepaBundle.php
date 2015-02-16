<?php

namespace ChrKo\Bundles\SepaBundle;

use ChrKo\Bundles\SepaBundle\DependencyInjection\ChrKoBundlesSepaExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class ChrKoBundlesSepaBundle
 * @package ChrKo\Bundles\SepaBundle
 */
class ChrKoBundlesSepaBundle extends Bundle
{
    /**
     * @return ChrKoBundlesSepaExtension
     */
    public function getContainerExtension() {
        return new ChrKoBundlesSepaExtension();
    }
}
