<?php

namespace Limenius\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class AbstractTransformer
{
    protected function getLabel($form, &$schema) {
        if ($label = $form->getConfig()->getOption('label')) {
            $schema['title'] = $label;
        }
    }
}
