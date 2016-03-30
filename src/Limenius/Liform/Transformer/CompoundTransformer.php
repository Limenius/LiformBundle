<?php

namespace Limenius\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class CompoundTransformer
{
    public function __construct($resolver) {
        $this->resolver = $resolver;
    }

    public function transform(FormInterface $form)
    {
        $data = [];
        $order = 1;
        foreach ($form->all() as $name => $field) {
            $transformedChild = $this->resolver->resolve($field)->transform($field);
            $transformedChild['propertyOrder'] = $order;
            $data[$name] = $transformedChild;
            $order ++;
        }
        return [
            'title' => $form->getConfig()->getOption('label'),
            'properties' => $data
        ];
    }
}
