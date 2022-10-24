<?php

namespace ChatBot\Bot\Chatting\Channel;

use Psr\Container\ContainerInterface;
use ChatBot\Bot\Chatting\Resolving\StepResolver;
use ChatBot\Bot\Conversation\Conversation;
use ChatBot\Bot\Chatting\Channel\Session;
use ChatBot\Bot\Chatting\Dialog\Dialog;
use ChatBot\Bot\Chatting\Resolving\FallbackStack;
use ChatBot\Bot\Conversation\Requests\Request;

class Channel
{
    private ?Dialog $dialog;

    private Session $session;

    private int $id;


    public function __construct(int $id, ?Dialog $dialog = null)
    {
        $this->session = new Session();
        $this->dialog = $dialog;
        $this->id = $id;
    }

    public function forceEnd()
    {
        $this->dialog = null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function isProcesseingDialog(): bool
    {
        return (bool) $this->dialog;
    }

    public function setDialog(Dialog $dialog): void
    {
        if ($this->isProcesseingDialog())
            throw new \LogicException('Can\'t change dialog when current dialog isn\'t ended');

        $this->dialog = $dialog;
    }

    public function getDialog(): Dialog
    {
        if (!!!$this->isProcesseingDialog())
            throw new \LogicException('Dialog isn\'t defined');

        return $this->dialog;
    }

    public function handle(ContainerInterface $dependencies, Request $message): Conversation
    {
        if (!!!$this->isProcesseingDialog())
            throw new \LogicException('No dialog to proceed');

        // TO DO move this sh..
        $conversation = new Conversation();
        $container = new PrivateContainer($dependencies, $this->session);
        $container->set(Conversation::class, $conversation);
        $container->set(Session::class, $this->session);
        $container->set(Request::class, $message);
        $container->set(ChatBehaviour::class, new ChatBehaviour($this));
    
        $this->dialog->proceedWith(
            resolver: $this->makeStepResolver($container)
        );

        if (!!!$this->dialog || $this->dialog->ended())
            $this->forceEnd();
        
        return $conversation;
    }

    private function makeStepResolver(PrivateContainer $container)
    {
        $fallbacks = new FallbackStack();
        $fallbacks->forDialog($this->dialog->getFallback());
        
        return  new StepResolver(
            $container->getResolver(), 
            $fallbacks
        );
    }
}