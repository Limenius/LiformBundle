<?php

namespace Limenius\Liform\Tests\Transformer;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface; 
use Symfony\Component\Form\Tests\AbstractFormTest;
use Limenius\Liform\Transformer\CompoundTransformer;
use Limenius\Liform\Resolver;

class CompoundTransformerTest extends AbstractFormTest
{

    public function testOrder()
    {
        $resolver = new Resolver();
        $this->form->add($this->getBuilder('firstName')->getForm());
        $this->form->add($this->getBuilder('lastName')->getForm());
        $transformer = new CompoundTransformer($resolver);
        $transformed = $transformer->transform($this->form);
        $this->assertTrue(is_array($transformed));
    }

    protected function createForm()
    {
        return $this->getBuilder()
            ->setCompound(true)
            ->setDataMapper($this->getDataMapper())
            ->getForm();
    }
}
