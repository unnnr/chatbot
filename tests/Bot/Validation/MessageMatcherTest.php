<?php

namespace ChatBot\Tests\Bot\Routing;

use ChatBot\Bot\Validation\Builders\MessageMatcher;
use ChatBot\Bot\Validation\Patterns\MessagePattern;
use ChatBot\Bot\Conversation\Requests\Request;
use PHPUnit\Framework\TestCase;

class MessageMatcherTest extends TestCase
{
    private $matcher;

    private $request;


    public function setUp(): void
    {   
        $this->matcher = new MessageMatcher();
        $this->request = $this->createStub(Request::class);
    }

    public function testCallsMatchingCallback()
    {
        $pattern = $this->createMock(MessagePattern::class);
        $pattern->expects($this->any())
            ->method('match')
            ->willReturn(true);

        $response = 123;
        $this->matcher->on($pattern)
            ->call(fn () => $response);

        $this->assertSame(
            expected: $response,
            actual: $this->matcher->handle($this->request)
        );
    }

    public function testHandlesFirstMatchedCase()
    {
        $pattern = $this->createMock(MessagePattern::class);
        $pattern->expects($this->any())
            ->method('match')
            ->willReturn(true);

        $validResponse = 'yes';
        $invalidResponse = 'nope';

        $this->matcher->on($pattern)
            ->call(fn () => $validResponse);

        $this->matcher->on($pattern)
            ->call(fn () => $invalidResponse);

        $this->assertSame(
            expected: $validResponse,
            actual: $this->matcher->handle($this->request)
        );
    }

    public function testReturnsNullIfNothingMatched()
    {
        $pattern = $this->createMock(MessagePattern::class);
        $pattern->expects($this->any())
            ->method('match')
            ->willReturn(false);

        $this->matcher->on($pattern)
            ->call(fn () => 'not this time');

        $this->assertNull(
            actual: $this->matcher->handle($this->request)
        );
    }

    public function testReturnsNullIfAnyPatternsAssigned()
    {
        $this->assertNull(
            actual: $this->matcher->handle($this->request)
        );
    }
}