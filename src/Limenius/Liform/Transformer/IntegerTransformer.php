<?php

namespace Limenius\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class IntegerTransformer
{
    public function transform(FormInterface $form)
    {
        return [
            'type' => 'integer',
        ];

    }
}
