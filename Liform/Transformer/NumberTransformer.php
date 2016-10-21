<?php

namespace Limenius\LiformBundle\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class NumberTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form, $extensions = [])
    {
        $schema = [
            'type' => 'number',
        ];
        if ($liform = $form->getConfig()->getOption('liform')) {
            if ($format = $liform['format']) {
                $schema['format'] = $format;
            }
        }
        $this->addCommonSpecs($form, $schema, $extensions);

        return $schema;
    }
}
