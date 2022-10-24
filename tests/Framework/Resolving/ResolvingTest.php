<?php

namespace ChatBot\Tests\Framework\Resolving;

use Psr\Container\ContainerInterface;
use ChatBot\Framework\DI\Resolving\Resolver;
use PHPUnit\Framework\TestCase;

class ResolvingTest extends TestCase
{
    private $container;

    private $dependecy;
    
    private $resolver;


    public function setUp(): void
    {   
        $this->container = $this->createMock(ContainerInterface::class);
        $this->resolver = new Resolver($this->container);
        $this->dependecy = new \ArrayIterator();

        $this->container->method('get')
            ->with(\Iterator::class)
            ->willReturn($this->dependecy);

    }

    public function testConstructorResolving()
    {   
        $resolved = $this->resolver->create(DummyForResolving::class);

        $this->assertSame(
            expected: $this->dependecy,
            actual: $resolved->dependecy
        );
    }

    public function testMethodResolvingWithClassName()
    {   
        $resolved = $this->resolver->invokeMethod(DummyForResolving::class, 'init');

        $this->assertSame(
            expected: $this->dependecy,
            actual: $resolved
        );
    }

    public function testMethodResolvingWithInstance()
    {   
        $target = new DummyForResolving($this->dependecy);
        $resolved = $this->resolver->invokeMethod($target, 'init');

        $this->assertTrue($target->methodCalled);
        $this->assertSame(
            expected: $this->dependecy,
            actual: $resolved
        );
    }

    public function testInvokeCallableArray()
    {   
        $target = new DummyForResolving($this->dependecy);
        $resolved = $this->resolver->invoke([$target, 'init']);

        $this->assertTrue($target->methodCalled);
        $this->assertSame(
            expected: $this->dependecy,
            actual: $resolved
        );
    }

    public function testInvokeAnonFunction()
    {   
        $methodCalled = false;

        $resolvable = function(\Iterator $dependecy) use (&$methodCalled) {
            $methodCalled = true;
            return $dependecy;
        };

        $resolved = $this->resolver->invoke($resolvable);

        $this->assertTrue($methodCalled);
        $this->assertSame(
            expected: $this->dependecy,
            actual: $resolved
        );
    }

    public function testFailesIfDependencyHasUnionType()
    {   
        $unresolvable = fn (\Throwable&\Iterator $dependecy) => true;

        $this->expectException(\LogicException::class);
        $this->resolver->invoke($unresolvable);
    }

    public function testFailesIfDependencyHasIntersectionType()
    {   
        $unresolvable = fn (\Throwable&\Iterator $dependecy) => true;

        $this->expectException(\LogicException::class);
        $this->resolver->invoke($unresolvable);
    }
}