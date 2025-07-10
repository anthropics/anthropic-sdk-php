<?php

namespace Anthropic\Errors;

class UnprocessableEntityError extends APIStatusError
{
    /** @var string */
    protected const DESC = 'Anthropic Unprocessable Entity Error';
}
