<?php

namespace ChatBot\Tests\Bot\Routing;

use ChatBot\Bot\Validation\Builders\MessageMatcher;
use ChatBot\Bot\Chatting\Description\DialogDescriptor;
use ChatBot\Bot\Chatting\Description\DialogFactory;
use ChatBot\Bot\Conversation\Requests\DummyRequest;
use ChatBot\Bot\Routing\RouteMatcher;
use PHPUnit\Framework\TestCase;

class RouteMatcherTest extends TestCase
{
    private $command;

    private $request;

    private $matcher;


    public function setUp(): void
    {
        $this->command = 'some';
        $this->request = new DummyRequest('!'.$this->command, 1, 1);
        $this->matcher = new RouteMatcher(new MessageMatcher(), new DialogFactory());
    }

    public function testMathingNotFailingWithoutRoutes()
    {
        $this->assertNull(
            actual: $this->matcher->handle($this->request)
        );
    }
    
    public function testCreatesMatchedDialogFromDescriptor()
    {
        $descriptor = $this->createMock(DialogDescriptor::class);
        $descriptor->expects($this->once())
            ->method('makeDialog');

        $this->matcher->on($this->command, $descriptor);
        $this->matcher->handle($this->request);
    }

    public function testReturnsNullIfNothingMatched()
    {
        $descriptor = $this->createMock(DialogDescriptor::class);
        $descriptor->expects($this->never())
            ->method('makeDialog');

        $this->matcher->on('wrongCommand', $descriptor);
        $this->assertNull(
            actual: $this->matcher->handle($this->request));
    }

    public function testReturnsFirstIfSeveralMatched()
    {
        $firstDescriptor = $this->createMock(DialogDescriptor::class);
        $firstDescriptor->expects($this->once())
            ->method('makeDialog');

        $secondDescriptor = $this->createMock(DialogDescriptor::class);
        $secondDescriptor->expects($this->never())
            ->method('makeDialog');

        $this->matcher->on($this->command, $firstDescriptor);
        $this->matcher->on($this->command, $secondDescriptor);

        $this->assertNotNull(
            actual: $this->matcher->handle($this->request)
        );
    }
}