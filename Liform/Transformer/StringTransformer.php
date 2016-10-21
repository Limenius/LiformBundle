<?php

namespace Limenius\LiformBundle\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class StringTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form, $extensions = [])
    {
        $schema = [
            'type' => 'string',
        ];


        if ($liform = $form->getConfig()->getOption('liform')) {
            if (isset($liform['format']) && $format = $liform['format']) {
                $schema['format'] = $format;
            }
        }

        $this->addCommonSpecs($form, $schema, $extensions);

        return $schema;
    }

}
