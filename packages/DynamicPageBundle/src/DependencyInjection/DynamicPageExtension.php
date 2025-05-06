<?php

namespace Dadoush\DynamicPageBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class DynamicPageExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container): void
    {
        $bundles = $container->getParameter('kernel.bundles');
        $configToLoad = ['services.yaml'];

        if (isset($bundles['EasyAdminBundle'])) {
            $locator = new FileLocator(__DIR__.'/../Resources/config/easyadmin');
            //$configToLoad[] = 'easyadmin.yaml';
        } else {
            // no EasyAdminBundle → load your own admin services
            $locator = new FileLocator(__DIR__.'/../Resources/config/admin');
        }

        $loader  = new YamlFileLoader($container, $locator);
        foreach ($configToLoad as $path) {
            $loader->load($path);
        }
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        // process bundle config
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // set parameters
        $container->setParameter('dynamic_page.default_template', $config['default_template']);

        // load our service definitions
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
    }
}