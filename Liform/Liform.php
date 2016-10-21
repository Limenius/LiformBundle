<?php

namespace Limenius\LiformBundle\Liform;
use Symfony\Component\Form\FormInterface;
use Limenius\Liform\Transformer\CompoundTransformer;

class Liform
{
    private $resolver;

    private $extensions = [];

    public function __construct(Resolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function transform(FormInterface $form)
    {
        return $this->resolver->resolve($form)->transform($form, $this->extensions);
    }

    public function addExtension($extension)
    {
        $this->extensions[] = $extension;
        return $this;
    }
}
