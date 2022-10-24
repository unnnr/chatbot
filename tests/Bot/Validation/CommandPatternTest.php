<?php

namespace ChatBot\Tests\Bot\Routing;

use ChatBot\Bot\Validation\Builders\PatternsFactory;
use ChatBot\Bot\Conversation\Requests\DummyRequest;
use ChatBot\Bot\Conversation\Requests\Request;
use PHPUnit\Framework\TestCase;

class CommandPatternTest extends TestCase
{
    private $patterns;


    public function setUp(): void
    {   
        $this->patterns = new PatternsFactory();
    }

    public function testComandPattern()
    {
        $pattern = $this->patterns->command('asd');

        $this->assertTrue($pattern->match($this->createRequest('!asd')));
        $this->assertTrue($pattern->match($this->createRequest(' !asd 1 1 1')));
        $this->assertTrue($pattern->match($this->createRequest('  !asd    ')));

        $this->assertFalse($pattern->match($this->createRequest('asd')));
        $this->assertFalse($pattern->match($this->createRequest('!')));
        $this->assertFalse($pattern->match($this->createRequest('!!asd')));
        $this->assertFalse($pattern->match($this->createRequest('1 !asd')));
    }

    public function testRegexPattern()
    {
        $pattern = $this->patterns->regex("/^\d*$/");
        
        $this->assertTrue($pattern->match($this->createRequest('1231412')));
        $this->assertTrue($pattern->match($this->createRequest('1')));
        $this->assertTrue($pattern->match($this->createRequest('')));

        $this->assertFalse($pattern->match($this->createRequest(' d')));
        $this->assertFalse($pattern->match($this->createRequest('1a')));
        $this->assertFalse($pattern->match($this->createRequest(' 6 ')));
    }

    private function createRequest(string $message): Request
    {
        return new DummyRequest($message, 0 , 0);
    }
}