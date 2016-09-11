<?php

namespace Limenius\LiformBundle\Liform\Transformer;
use Symfony\Component\Form\FormInterface;

class AbstractTransformer
{
    protected function addCommonSpecs($form, &$schema)
    {
        $this->addLabel($form, $schema);
        $this->addAttr($form, $schema);
        $this->addPattern($form, $schema);
        $this->addDefault($form, $schema);
        $this->addDescription($form, $schema);
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

    protected function addDescription($form, &$schema) {
        if ($liform = $form->getConfig()->getOption('liform')) {
            if (isset($liform['description']) && $description = $liform['description']) {
                $schema['description'] = $description;
            }
        }
    }

    protected function isRequired($form)
    {
        return $form->getConfig()->getOption('required');
    }
}
