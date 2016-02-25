<?php

namespace Limenius\FormJsonSchemaTransformer\Transformer;
use Symfony\Component\Form\FormInterface;

class ChoiceTransformer
{
    public function transform(FormInterface $form)
    {
        $formView = $form->createView();

        $choices = [];
        foreach ($formView->vars['choices'] as $choiceView) {
            $choices[] = $choiceView->value;
        }
        return [
            'enum' => $choices
            ];

    }
}
