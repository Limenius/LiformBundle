<?php

namespace Limenius\LiformBundle\DependencyInjection\Compiler;

use Limenius\Liform\Transformer\ExtensionInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ExtensionCompilerPass implements CompilerPassInterface
{
    const EXTENSION_TAG = 'liform.extension';

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('liform')) {
            return;
        }

        $liform = $container->getDefinition('liform');

        foreach ($container->findTaggedServiceIds(self::EXTENSION_TAG) as $id => $attributes) {
            $extension = $container->getDefinition($id);
            $class = $this->getManagedClass($extension, $container);

            if (!isset(class_implements($class)[ExtensionInterface::class])) {
                throw new \InvalidArgumentException(sprintf(
                    "The service %s was tagged as a '%s' but does not implement the mandatory %s",
                    $id,
                    self::EXTENSION_TAG,
                    ExtensionInterface::class
                ));
            }

            $liform->addMethodCall('addExtension', [$extension]);
        }
    }

    /**
     * Resolves the class argument of the service to an actual class (in case of %parameter%).
     *
     * @param Definition       $service
     * @param ContainerBuilder $container
     *
     * @return string
     */
    private function getManagedClass(Definition $service, ContainerBuilder $container)
    {
        $class = $service->getClass();

        if (class_exists($class)) {
            return $class;
        }

        return $container->getParameterBag()->resolveValue($class);
    }
}
