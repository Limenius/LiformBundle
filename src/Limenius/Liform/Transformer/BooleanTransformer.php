<?php

namespace Limenius\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class BooleanTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form)
    {
        $schema = ['type' => 'boolean'];
        if (isset($liform['description']) && $description = $liform['description']) {
            $schema['description'] = $description;
        }
        $this->addCommonSpecs($form, $schema);

        return $schema;
    }
}
