<?php

namespace Limenius\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class AbstractTransformer
{
    protected function addCommonSpecs($form, &$schema)
    {
        $this->addLabel($form, $schema);
        $this->addAttr($form, $schema);
        $this->addPattern($form, $schema);
        $this->addDefault($form, $schema);
    }


    protected function addDefault($form, &$schema)
    {
        if ($attr = $form->getConfig()->getOption('attr')) {
            if (isset($attr['placeholder'])) {
                $schema['default'] = $attr['placeholder'];
            }
        }
    }

    protected function addPattern($form, &$schema)
    {
        if ($attr = $form->getConfig()->getOption('attr')) {
            if (isset($attr['pattern'])) {
                $schema['pattern'] = $attr['pattern'];
            }
        }
    }

    protected function addLabel($form, &$schema)
    {
        if ($label = $form->getConfig()->getOption('label')) {
            $schema['title'] = $label;
        }
    }

    protected function addAttr($form, &$schema) {
        if ($attr = $form->getConfig()->getOption('attr')) {
            $schema['attr'] = $attr;
        }
    }

    protected function isRequired($form)
    {
        return $form->getConfig()->getOption('required');
    }
}
