<?php

namespace Limenius\LiformBundle\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class BooleanTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form, $extensions = [], $format = null)
    {
        $schema = ['type' => 'boolean'];

        $this->addCommonSpecs($form, $schema, $extensions, $format);

        return $schema;
    }
}
