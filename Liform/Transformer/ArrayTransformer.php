<?php

namespace Limenius\LiformBundle\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class ArrayTransformer extends AbstractTransformer
{
    public function __construct($resolver) {
        $this->resolver = $resolver;
    }

    public function transform(FormInterface $form, $extensions = [], $format = null)
    {
        $children = [];
        //$entryType = $form->getConfig()->getAttribute('prototype');
        //$children[] = $this->resolver->resolve($entryType)->transform($entryType, $extensions);
        //$children[0]['title'] = 'prototype';
        foreach ($form->all() as $name => $field) {
            $transformerData = $this->resolver->resolve($form);
            $transformedChild = $transformerData['transformer']->transform($field, $extensions, $transformerData['format']);
            $children[] = $transformedChild;

            if ($transformerData['transformer']->isRequired($field)) {
                $required[] = $field->getName();
            }
        }
        $schema =[
            'type' => 'array',
            'title' => $form->getConfig()->getOption('label'),
            'items' => $children[0]
        ];

        $schema = $this->addCommonSpecs($form, $schema, $extensions, $format);

        return $schema;
    }
}
