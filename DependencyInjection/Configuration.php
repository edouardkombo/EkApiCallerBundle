<?php

namespace EdouardKombo\EkApiCallerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ek_api_caller');

        $rootNode
            ->children()
                ->booleanNode('cache')->end()                
                ->integerNode('timeout')->end()
                ->integerNode('connect_timeout')->end()                
                ->booleanNode('verify_ssl_certificates')
                    ->defaultTrue()
                    ->info('Should SSL certificates be verified?')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
