<?php

namespace Anthropic\Core\Errors;

class InternalServerError extends APIStatusError
{
    /** @var string */
    protected const DESC = 'Anthropic Internal Server Error';
}
