<?php

namespace Limenius\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class BooleanTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form)
    {
        $schema = ['type' => 'boolean'];
        $this->addCommonSpecs($form, $schema);

        return $schema;
    }
}
