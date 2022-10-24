<?php

namespace ChatBot\Bot\Validation\Expressions;

interface Expression
{
    function proceed(): mixed;
}