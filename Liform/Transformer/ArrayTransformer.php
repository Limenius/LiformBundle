<?php

namespace Limenius\LiformBundle\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class ArrayTransformer extends AbstractTransformer
{
    public function __construct($resolver) {
        $this->resolver = $resolver;
    }

    public function transform(FormInterface $form, $extensions = [])
    {
        $children = [];
        //$entryType = $form->getConfig()->getAttribute('prototype');
        //$children[] = $this->resolver->resolve($entryType)->transform($entryType, $extensions);
        //$children[0]['title'] = 'prototype';
        foreach ($form->all() as $name => $field) {
            $transformedChild = $this->resolver->resolve($field)->transform($field, $extensions);
            $children[] = $transformedChild;

            if ($this->resolver->resolve($field)->isRequired($field)) {
                $required[] = $field->getName();
            }
        }
        $schema =[
            'type' => 'array',
            'title' => $form->getConfig()->getOption('label'),
            'items' => $children[0]
        ];

        $this->addCommonSpecs($form, $schema, $extensions);

        return $schema;
    }
}
