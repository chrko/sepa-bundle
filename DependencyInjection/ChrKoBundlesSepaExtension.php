<?php

namespace ChrKo\Bundles\SepaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ChrKoBundlesSepaExtension
    extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if ($config['driver'] == 'none') {
            throw new \InvalidArgumentException('you have to specify a driver');
        }

        foreach ($config['options'] as $id => $option) {
            $container->setParameter('chrko.sepa.driver.option' . $id, $option);
        }

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $container->setAlias('chrko.sepa.driver', 'chrko.sepa.driver.' . $config['driver']);
    }

    public function getAlias()
    {
        return 'chrko_sepa';
    }
}
