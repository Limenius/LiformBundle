<?php

namespace Limenius\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class NumberTransformer
{
    public function transform(FormInterface $form)
    {
        return [
            'type' => 'number'
        ];

    }
}
