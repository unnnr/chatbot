<?php

namespace ChatBot\Example\App\Dialogs;

use ChatBot\Bot\Chatting\Description\Building\BuildingDescriptor;
use ChatBot\Bot\Chatting\Description\Building\DialogBuilder;
use ChatBot\Bot\Chatting\Channel\ChatBehaviour;
use ChatBot\Bot\Conversation\Requests\Request;
use ChatBot\Bot\Chatting\Channel\Session;
use ChatBot\Bot\Conversation\Conversation;

class ManuallyDescribedDialog extends BuildingDescriptor
{
    public function describe(DialogBuilder $dialog): void
    {
        $dialog
            ->startWithoutReply()
            ->defineFallback([$this, 'dialogFails'])
            ->group()
                ->handleReply([$this, 'initDialog'])
                ->sendMessage('STARTED MANUALLY BUILDED DIALOG')
                ->sendMessage('Your name')
            ->end()
            ->group()
                ->handleReply([$this, 'saveName'])
                ->sendMessage('Your surmane')
            ->end()
            ->group()
                ->handleReply([$this, 'saveSurname'])
                ->handleReply([$this, 'createUser'])
            ->end();
    }

    public function initDialog(Session $session)
    {
        $session->set(CustomerBuilder::class, new CustomerBuilder());
    }

    public function saveName(Request $message, CustomerBuilder $builder)
    {
        $builder->setName($message->getText());
    }

    public function saveSurname(Request $message, CustomerBuilder $builder)
    {
        $builder->setSurname($message->getText());
    }

    public function createUser(Conversation $conversation, CustomerBuilder $builder)
    {
        $customer = $builder->make();

        $response = 'The loan was successfully issued in the name of %s %s.';
        $formated = sprintf($response, $customer['name'], $customer['surname']);
        $conversation->addReponse($formated);
      
        $conversation->addReponse('Have a nice day!');
        $conversation->addReponse('DIALOG ENDED');
    }

    public function dialogFails(ChatBehaviour $chat, Conversation $conversation)
    {
        $conversation->addReponse('Something went wrong. Please, Try again');
        $chat->endDialog();

        // logging logic here
    }
}