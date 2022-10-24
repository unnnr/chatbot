<?php

namespace ChatBot\Tests\Framework;

use ChatBot\Framework\Kernel;
use PHPUnit\Framework\TestCase;
use ChatBot\Framework\Booter;

class KernelTest extends TestCase
{
    private $kernel;

    private $booter;


    public function setUp(): void
    {   
        $this->booter = $this->createMock(Booter::class);
        $this->kernel = $this->getMockBuilder(Kernel::class)
            ->setConstructorArgs(['', $this->booter])
            ->getMockForAbstractClass();
    }

    public function testCreatesContainerWithBooter()
    {
        $this->booter->expects($this->once())
            ->method('loadEnvFrom');

        $this->booter->expects($this->once())
            ->method('loadConfigFrom');

        $this->booter->expects($this->once())
            ->method('loadDependenciesFrom');

        $this->booter->expects($this->once())
            ->method('getContainer');

        $this->kernel->boot();
    }

    public function testBootingStopsIfAppIsNull()
    {
        $this->kernel->expects($this->once())
            ->method('getAppClass')
            ->willReturn(null);

        $this->kernel->boot();
    }

    public function testBootingFailsIfAppIsIncorrent()
    {
        $this->kernel->expects($this->any())
            ->method('getAppClass')
            ->willReturn('wrong string');

        $this->expectException(\LogicException::class);
        $this->kernel->boot();
    }
}