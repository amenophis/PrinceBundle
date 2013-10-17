<?php

namespace Amenophis\Bundle\PrinceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
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
        $rootNode = $treeBuilder->root('amenophis_prince');

        $optionsBuilder = $rootNode
            ->children()
                ->scalarNode('binary_path')
                    ->isRequired()
                ->end()
                ->arrayNode('generators')
                    ->prototype('array')
                        ->children();

        $this->createGeneralOptions($optionsBuilder);
        $this->createInputOptions($optionsBuilder);
        $this->createNetworkOptions($optionsBuilder);
        $this->createJavaScriptOptions($optionsBuilder);
        $this->createCSSOptions($optionsBuilder);
        $this->createPDFOutputOptions($optionsBuilder);
        $this->createPDFMetadataOptions($optionsBuilder);
        $this->createPDFEncryptionOptions($optionsBuilder);
        $this->createUtilityOptions($optionsBuilder);

        return $treeBuilder;
    }

    public function createGeneralOptions(NodeBuilder $builder){
        $builder
            ->booleanNode('help')
                ->defaultFalse()
            ->end()
            ->booleanNode('version')
                ->defaultFalse()
            ->end()
            ->booleanNode('verbose')
                ->defaultFalse()
            ->end()
            ->scalarNode('log')
                ->defaultValue('%kernel.root_dir%/app/logs/prince.log')
            ->end()
        ;
    }

    public function createInputOptions(NodeBuilder $builder){
        $builder
            ->enumNode('input')
                ->values(array('auto', 'xml', 'html', 'html5'))
                ->defaultValue('auto')
            ->end()
            ->scalarNode('input_list')->end()
            ->scalarNode('baseurl')->end()
            ->scalarNode('fileroot')->end()
            ->booleanNode('no_xinclude')
                ->defaultFalse()
            ->end()
        ;
    }

    public function createNetworkOptions(NodeBuilder $builder){
        $builder
            ->booleanNode('no_network')
                ->defaultFalse()
            ->end()
            ->scalarNode('http_user')->end()
            ->scalarNode('http_password')->end()
            ->scalarNode('http_proxy')->end()
            ->scalarNode('http_timeout')->end()
            ->scalarNode('cookiejar')->end()
            ->scalarNode('ssl_cacert')->end()
            ->scalarNode('ssl_capath')->end()
            ->booleanNode('insecure')
                ->defaultFalse()
            ->end()
        ;
    }

    public function createJavaScriptOptions(NodeBuilder $builder){
        $builder
            ->booleanNode('javascript')
                ->defaultFalse()
            ->end()
            ->scalarNode('script')->end()
        ;
    }

    public function createCSSOptions(NodeBuilder $builder){
        $builder
            ->scalarNode('style')->end()
            ->scalarNode('media')->end()
            ->booleanNode('no_author_style')
                ->defaultFalse()
            ->end()
            ->booleanNode('no_default_style')
                ->defaultFalse()
            ->end()
        ;
    }

    public function createPDFOutputOptions(NodeBuilder $builder){
        $builder
            ->scalarNode('output')->end()
            ->scalarNode('profile')->end()
            ->scalarNode('attach')->end()
            ->booleanNode('no_embed_fonts')
                ->defaultFalse()
            ->end()
            ->booleanNode('no_subset_fonts')
                ->defaultFalse()
            ->end()
            ->booleanNode('no_compress')
                ->defaultFalse()
            ->end()
        ;
    }

    public function createPDFMetadataOptions(NodeBuilder $builder){
        $builder
            ->scalarNode('pdf_title')->end()
            ->scalarNode('pdf_subject')->end()
            ->scalarNode('pdf_author')->end()
            ->scalarNode('pdf_keywords')->end()
            ->scalarNode('pdf_creator')->end()
        ;
    }

    public function createPDFEncryptionOptions(NodeBuilder $builder){
        $builder
            ->booleanNode('encrypt')
                ->defaultFalse()
            ->end()
            ->enumNode('key_bits')
                ->values(array('40', '128'))
                ->defaultValue('40')
            ->end()
            ->scalarNode('user_password')->end()
            ->scalarNode('owner_password')->end()
            ->booleanNode('disallow_print')
                ->defaultFalse()
            ->end()
            ->booleanNode('disallow_copy')
                ->defaultFalse()
            ->end()
            ->booleanNode('disallow_annotate')
                ->defaultFalse()
            ->end()
            ->booleanNode('disallow_modify')
                ->defaultFalse()
            ->end()
        ;
    }

    public function createUtilityOptions(NodeBuilder $builder){
        $builder
            ->scalarNode('scanfonts')->end()
        ;
    }
}