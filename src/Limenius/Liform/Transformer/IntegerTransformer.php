<?php

namespace Limenius\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class IntegerTransformer
{
    public function transform(FormInterface $form)
    {
        $schema = [
            'type' => 'integer',
        ];
        if ($liform = $form->getConfig()->getOption('liform')) {
            if ($format = $liform['format']) {
                $schema['format'] = $format;
            }
        }
        return $schema;

    }
}
