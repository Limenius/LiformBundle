<?php

namespace Limenius\FormJsonSchemaTransformer\Tests;
use Limenius\FormJsonSchemaTransformer\Resolver;

class ResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testEval()
    {
        $resolver = new Resolver();
        $this->assertInstanceOf(Resolver::class, $resolver);
    }

}

