<?php

namespace ChatBot\Tests\Bot\Routing;

use ChatBot\Bot\Validation\Builders\MessageMatcher;
use ChatBot\Bot\Chatting\Description\DialogDescriptor;
use ChatBot\Bot\Chatting\Description\DialogFactory;
use ChatBot\Bot\Conversation\Requests\DummyRequest;
use ChatBot\Bot\Chatting\Channel\ChannelStorage;
use ChatBot\Bot\Chatting\Channel\Channel;
use ChatBot\Bot\Routing\RouterDescriptor;
use ChatBot\Bot\Routing\RouterService;
use ChatBot\Bot\Routing\RouteMatcher;
use PHPUnit\Framework\TestCase;

class RouterServiceTest extends TestCase
{
    private $storage;

    private $channel;

    private $request;

    private $matcher;

    private $descriptor;

    
    protected function setUp(): void
    {
        $this->matcher = new RouteMatcher(new MessageMatcher(), new DialogFactory());
        $this->descriptor = $this->createStub(RouterDescriptor::class);

        $this->request = new DummyRequest('!some', 123, 32);
        $this->channel = $this->createMock(Channel::class);

        $this->storage = $this->createStub(ChannelStorage::class);
        $this->storage->method('findOrCreateBy')
            ->willReturn($this->channel);
    }

    public function testReturnsChannelWhenItProccessing()
    {
        $this->channel->expects($this->never())
            ->method('setDialog');

        $this->channel->method('isProcesseingDialog')
            ->willReturn(true);

        $router = new RouterService($this->matcher, $this->storage, $this->descriptor);

        $this->assertSame($this->channel, $router->match($this->request));
    }

    public function testChangesChannelDialog()
    {
        $dialog = $this->createStub(DialogDescriptor::class);
        $this->matcher->on('some', $dialog);

        $this->channel->expects($this->once())
            ->method('setDialog');

        $this->channel->method('isProcesseingDialog')
            ->willReturn(false);

        $router = new RouterService($this->matcher, $this->storage, $this->descriptor);

        $this->assertSame($this->channel, $router->match($this->request));
    }


    public function testReturnsNullIfMatcherCantFindAnything()
    {
        $this->channel->method('isProcesseingDialog')
            ->willReturn(false);

        $router = new RouterService($this->matcher, $this->storage, $this->descriptor);

        $this->assertSame(null, $router->match($this->request));
    }
}