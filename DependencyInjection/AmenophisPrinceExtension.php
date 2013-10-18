<?php

namespace Amenophis\Bundle\PrinceBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AmenophisPrinceExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        foreach ($config['generators'] as $key => $generator) {
            $configDef = new Definition('%amenophis.prince.configuration.class%');
            $configDef->addMethodCall('setConfig', array($generator));
            $configDef->setPublic(false);
            $container->setDefinition(sprintf('amenophis_prince.%s_configuration', $key), $configDef);

            $commandDef = new Definition('%amenophis.prince.command.class%');
            $commandDef->addArgument($config['binary_path']);
            $commandDef->addArgument($configDef);
            $commandDef->setPublic(false);
            $container->setDefinition(sprintf('amenophis_prince.%s_command', $key), $commandDef);

            $generatorDef = new Definition('%amenophis.prince.generator.class%');
            $generatorDef->addArgument($commandDef);
            $container->setDefinition(sprintf('amenophis_prince.%s_generator', $key), $generatorDef);
        }
    }
}
