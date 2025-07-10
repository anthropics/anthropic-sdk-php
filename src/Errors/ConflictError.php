<?php

namespace Anthropic\Errors;

class ConflictError extends APIStatusError
{
    /** @var string */
    protected const DESC = 'Anthropic Conflict Error';
}
