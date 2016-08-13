<?php

namespace Limenius\Liform\Tests\Transformer;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Tests\AbstractFormTest;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Limenius\Liform\Transformer\CompoundTransformer;
use Limenius\Liform\Transformer\StringTransformer;
use Limenius\Liform\Resolver;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Constraints as Assert;
use Limenius\Liform\Form\Extension\AddLiformExtension;
use Symfony\Component\Form\FormTypeExtensionInterface;

class StringTransformerTest extends TypeTestCase
{
    //protected function getExtensions()
    //{
    //    $ext = new AddLiformExtension();
    //    return array_merge(parent::getExtensions(), array(
    //        new AddLiformExtension(),
    //    ));
    //}

    public function testPattern()
    {
        $form = $this->factory->create(FormType::class)
            ->add(
                'firstName',
                TextType::class,
                ['attr' => ['pattern' => '.{5,}' ]]
            );
        $resolver = new Resolver();
        $resolver->addTransformer('text', new StringTransformer());
        $transformer = new CompoundTransformer($resolver);
        $transformed = $transformer->transform($form);
        $this->assertTrue(is_array($transformed));
        $this->assertEquals('.{5,}', $transformed['properties']['firstName']['pattern']);
    }

    public function testRequired()
    {
        $form = $this->factory->create(FormType::class)
            ->add(
                'firstName',
                TextType::class,
                ['required' => true]
            );
        $resolver = new Resolver();
        $resolver->addTransformer('text', new StringTransformer());
        $transformer = new CompoundTransformer($resolver);
        $transformed = $transformer->transform($form);

        $this->assertTrue(is_array($transformed));
        $this->assertArrayHasKey('required', $transformed);
        $this->assertTrue(is_array($transformed['required']));
        $this->assertContains('firstName', $transformed['required']);
    }

    // TODO: Uncoment this and solve the problem of extension not being recognized
    //public function testDescription()
    //{
    //    $form = $this->factory->create(FormType::class)
    //        ->add(
    //            'firstName',
    //            TextType::class,
    //            ['liform' => ['description' => 'A word that references you in the hash of the world']]
    //        );
    //    $resolver = new Resolver();
    //    $resolver->addTransformer('text', new StringTransformer());
    //    $transformer = new CompoundTransformer($resolver);
    //    $transformed = $transformer->transform($form);

    //    $this->assertTrue(is_array($transformed));
    //    $this->assertArrayHasKey('description', $transformed['properties']['firstName']);
    //}
}
