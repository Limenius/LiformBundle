<?php

namespace Limenius\LiformBundle\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class ArrayTransformer extends AbstractTransformer
{
    public function __construct($resolver) {
        $this->resolver = $resolver;
    }

    public function transform(FormInterface $form)
    {
        $entryType = $form->getConfig()->getAttribute('prototype');
        $items = $this->resolver->resolve($entryType)->transform($entryType);
        $items['type'] = 'object';
        $schema =[
            'type' => 'array',
            'title' => $form->getConfig()->getOption('label'),
            'items' => $items
        ];

        $this->addLabel($form, $schema);
        $this->addAttr($form, $schema);

        return $schema;
    }
}
