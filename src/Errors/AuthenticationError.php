<?php

namespace Anthropic\Errors;

class AuthenticationError extends APIStatusError
{
    /** @var string */
    protected const DESC = 'Anthropic Authentication Error';
}
