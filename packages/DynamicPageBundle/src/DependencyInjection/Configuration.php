<?php

namespace Dadoush\DynamicPageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('dynamic_page');
        $root = $treeBuilder->getRootNode();

        $root
            ->children()
                ->scalarNode('default_template')
                    ->defaultValue('@DynamicPage/components/default.html.twig')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
