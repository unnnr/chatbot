<?php

namespace ChatBot\Example\App\Dialogs;

use ChatBot\Shared\Utilities\TrustedVariable;

class CustomerBuilder
{
    public function __construct(
        private TrustedVariable $name = new TrustedVariable(),
        private TrustedVariable $surname = new TrustedVariable()
    ) {}
    
    public function setName(string $name)
    {
        $this->name->setValue($name);
        return $this;
    }

    public function setSurname(string $surname)
    {
        $this->surname->setValue($surname);
        return $this;
    }

    public function make(): array
    {
        return [
            'surname' => $this->name->getValue(),
            'name' => $this->name->getValue()
        ];
    }
}