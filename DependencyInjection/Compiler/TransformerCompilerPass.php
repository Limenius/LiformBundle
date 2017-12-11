<?php

/*
 * This file is part of the Limenius\LiformBundle package.
 *
 * (c) Limenius <https://github.com/Limenius/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Limenius\LiformBundle\DependencyInjection\Compiler;

use Limenius\Liform\Transformer\TransformerInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @author Nacho Martín <nacho@limenius.com>
 */
class TransformerCompilerPass implements CompilerPassInterface
{
    const TRANSFORMER_TAG = 'liform.transformer';

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('liform.resolver')) {
            return;
        }

        $resolver = $container->getDefinition('liform.resolver');

        foreach ($container->findTaggedServiceIds(self::TRANSFORMER_TAG) as $id => $attributes) {
            if (!isset($attributes[0]['form_type'])) {
                throw new \InvalidArgumentException(sprintf(
                    "The service %s was tagged as a '%s' but does not specify the mandatory 'form_type' option.",
                    $id,
                    self::TRANSFORMER_TAG
                ));
            }

            $transformer = $container->getDefinition($id);
            $class = $this->getManagedClass($transformer, $container);

            if (!isset(class_implements($class)[TransformerInterface::class])) {
                throw new \InvalidArgumentException(sprintf(
                    "The service %s was tagged as a '%s' but does not implement the mandatory %s",
                    $id,
                    self::TRANSFORMER_TAG,
                    TransformerInterface::class
                ));
            }

            $widget = null;

            if (isset($attributes[0]['widget'])) {
                $widget = $attributes[0]['widget'];
            }

            $resolver->addMethodCall('setTransformer', [$attributes[0]['form_type'], $transformer, $widget]);
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
