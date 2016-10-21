<?php

namespace Limenius\LiformBundle\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class CompoundTransformer extends AbstractTransformer
{
    public function __construct($resolver) {
        $this->resolver = $resolver;
    }

    public function transform(FormInterface $form, $extensions = [])
    {
        $data = [];
        $order = 1;
        $required = [];
        foreach ($form->all() as $name => $field) {
            $transformedChild = $this->resolver->resolve($field)->transform($field, $extensions);
            $transformedChild['propertyOrder'] = $order;
            $data[$name] = $transformedChild;
            $order ++;

            if ($this->resolver->resolve($field)->isRequired($field)) {
                $required[] = $field->getName();
            }
        }
        $schema =[
            'title' => $form->getConfig()->getOption('label'),
            'type' => 'object',
            'properties' => $data
        ];

        if (!empty($required)) {
            $schema['required'] = $required;
        }
        $this->addCommonSpecs($form, $schema, $extensions);

        return $schema;
    }
}
