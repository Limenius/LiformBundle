<?php

namespace Limenius\LiformBundle\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class BooleanTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form, $extensions = [])
    {
        $schema = ['type' => 'boolean'];

        $this->addCommonSpecs($form, $schema, $extensions);

        return $schema;
    }
}
