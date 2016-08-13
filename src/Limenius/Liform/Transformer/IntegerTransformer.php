<?php

namespace Limenius\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class IntegerTransformer extends AbstractTransformer
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
        $this->addCommonSpecs($form, $schema);

        return $schema;
    }
}
