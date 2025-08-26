<?php

namespace Anthropic\Core\Errors;

class UnprocessableEntityError extends APIStatusError
{
    /** @var string */
    protected const DESC = 'Anthropic Unprocessable Entity Error';
}
