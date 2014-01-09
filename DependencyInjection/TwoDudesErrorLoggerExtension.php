<?php

namespace TwoDudes\ErrorLoggerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Exception\BadMethodCallException;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TwoDudesErrorLoggerExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (!isset($config['error_logger'])) {
            $container->setParameter('two_dudes.error_logger_enabled', false);
            return;
        } else {
            $container->setParameter('two_dudes.error_logger_enabled', true);
        }

        $container->setParameter('two_dudes.storage_service_id', $config['error_logger']['storage']['service']);
        $container->setParameter('two_dudes.storage_service_params', $config['error_logger']['storage']['params']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    public function getNamespace()
    {
        return 'two_dudes';
    }
}