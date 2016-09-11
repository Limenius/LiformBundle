<?php

namespace Limenius\LiformBundle\Tests\Liform;

use Limenius\LiformBundle\Liform\Resolver;

class ResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testEval()
    {
        $resolver = new Resolver();
        $this->assertInstanceOf(Resolver::class, $resolver);
    }

}
