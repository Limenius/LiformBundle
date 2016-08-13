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
        $required = [];
        foreach ($form->all() as $name => $field) {
            $transformedChild = $this->resolver->resolve($field)->transform($field);
            $transformedChild['propertyOrder'] = $order;
            $data[$name] = $transformedChild;
            $order ++;

            if ($this->resolver->resolve($field)->isRequired($field)) {
                $required[] = $field->getName();
            }
        }
        $schema =[
            'title' => $form->getConfig()->getOption('label'),
            'properties' => $data
        ];

        if (!empty($required)) {
            $schema['required'] = $required;
        }
        $this->addLabel($form, $schema);
        $this->addAttr($form, $schema);

        return $schema;
    }
}
