<?php

namespace Anthropic\Core\Errors;

class ConflictError extends APIStatusError
{
    /** @var string */
    protected const DESC = 'Anthropic Conflict Error';
}
