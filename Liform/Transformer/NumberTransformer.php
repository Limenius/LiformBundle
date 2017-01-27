<?php

namespace Limenius\LiformBundle\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class NumberTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form, $extensions = [], $format = null)
    {
        $schema = [
            'type' => 'number',
        ];
        if ($liform = $form->getConfig()->getOption('liform')) {
            if ($format = $liform['format']) {
                $schema['format'] = $format;
            }
        }
        $this->addCommonSpecs($form, $schema, $extensions, $format);

        return $schema;
    }
}
