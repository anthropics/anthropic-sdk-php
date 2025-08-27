<?php

namespace Anthropic\Core\Exceptions;

class AuthenticationException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Anthropic Authentication Exception';
}
