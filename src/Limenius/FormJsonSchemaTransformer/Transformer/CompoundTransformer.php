<?php

namespace Limenius\FormJsonSchemaTransformer\Transformer;
use Symfony\Component\Form\FormInterface;

class CompoundTransformer
{
    public function __construct($resolver) {
        $this->resolver = $resolver;
    }

    public function transform(FormInterface $form)
    {
        $data = [];
        foreach ($form->all() as $name => $field) {
            $data[$name] = $this->resolver->resolve($field)->transform($field);
        }
        return [
            'title' => $form->getConfig()->getOption('label'),
            'properties' => $data
        ];
    }
}
