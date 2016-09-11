<?php

namespace Limenius\LiformBundle\Liform;

use Symfony\Component\Form\FormInterface;
use Limenius\LiformBundle\Liform\Transformer\CompoundTransformer;

class Resolver
{
    private $transformers = [];

    public function addTransformer($formType, $transformer)
    {
        $this->transformers[$formType] = $transformer;
    }

    public function resolve(FormInterface $form)
    {
        $types = FormUtil::typeAncestry($form);

        foreach ($types as $type) {
            if (isset($this->transformers[$type])) {
                return $this->transformers[$type];
            }
        }

        // Perhaps a compound we don't have a specific transformer for
        if (FormUtil::isCompound($form)) {
            return new CompoundTransformer($this);
        }

        throw new \LogicException(
            sprintf(
                'Could not find a transformer for any of these types (%s)',
                implode(', ', $types)
            )
        );
    }

}
