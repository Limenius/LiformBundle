<?php

namespace Limenius\LiformBundle\Liform\Transformer;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\ChoiceList\View\ChoiceGroupView;

class ChoiceTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form)
    {
        $formView = $form->createView();

        $choices = [];
        $titles = [];
        foreach ($formView->vars['choices'] as $choiceView) {
            if ($choiceView instanceof ChoiceGroupView) {
                foreach ($choiceView->choices as $choiceItem) {
                    $choices[] = $choiceItem->value;
                    $titles[] = $choiceItem->label;
                }
            } else {
                $choices[] = $choiceView->value;
                $titles[] = $choiceView->label;
            }
        }
        $schema = [
            'enum' => $choices,
            'liform' => ['enum_titles' => $titles],
            'type' => 'string'
            ];

        $this->addCommonSpecs($form, $schema);

        return $schema;
    }
}
