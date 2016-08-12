<?php

namespace Limenius\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class CompoundTransformer extends AbstractTransformer
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
        $schema =[
            'title' => $form->getConfig()->getOption('label'),
            'properties' => $data
        ];
        $this->getLabel($form, $schema);

        return $schema;
    }
}
