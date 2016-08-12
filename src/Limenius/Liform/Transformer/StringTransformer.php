<?php

namespace Limenius\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class StringTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form)
    {
        $schema = [
            'type' => 'string',
        ];
        if ($liform = $form->getConfig()->getOption('liform')) {
            if ($format = $liform['format']) {
                $schema['format'] = $format;
            }
        }
        $this->getLabel($form, $schema);

        return $schema;
    }

}