<?php

namespace ChatBot\Example\App\Dialogs;

use ChatBot\Bot\Chatting\Description\Attributes\AttributeDescriptor;
use ChatBot\Bot\Chatting\Description\Attributes\Types as Types;
use ChatBot\Bot\Chatting\Channel\ChatBehaviour;
use ChatBot\Bot\Conversation\Requests\Request;
use ChatBot\Bot\Conversation\Conversation;
use ChatBot\Bot\Chatting\Channel\Session;

class AttributedDialog extends AttributeDescriptor
{
    #[Types\Step]
    public function initDialog(Session $session, Conversation $conversation)
    {
        $session->set(CustomerBuilder::class, new CustomerBuilder());
        $conversation->addReponse('STARTED ATTRIBUTED DIALOG');
        $conversation->addReponse('Your name');
    }

    #[Types\Step]
    #[Types\WaitForReply]
    public function saveName(Request $message, CustomerBuilder $builder, Conversation $conversation)
    {
        $builder->setName($message->getText());
        $conversation->addReponse('Your surname');
    }

    #[Types\Step]
    #[Types\WaitForReply]
    public function saveSurname(Request $message, CustomerBuilder $builder)
    {
        $builder->setSurname($message->getText());
    }

    #[Types\Step]
    public function createUser(Conversation $conversation, CustomerBuilder $builder)
    {
        $customer = $builder->make();

        $response = 'The loan was successfully issued in the name of %s %s.';
        $formated = sprintf($response, $customer['name'], $customer['surname']);
        $conversation->addReponse($formated);
      
        $conversation->addReponse('Have a nice day!');
        $conversation->addReponse('DIALOG ENDED');
    }

    #[Types\DialogFallback]
    public function dialogFails(ChatBehaviour $chat, Conversation $conversation)
    {
        $conversation->addReponse('Something went wrong. Please, Try again');
        $chat->endDialog();

        // logging logic here
    }
}