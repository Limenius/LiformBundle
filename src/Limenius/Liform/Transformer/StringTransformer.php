<?php

namespace Limenius\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class StringTransformer
{
    public function transform(FormInterface $form)
    {
        return [
            'type' => 'string',
        ];
    }
}
