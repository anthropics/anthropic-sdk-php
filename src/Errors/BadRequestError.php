<?php

namespace Anthropic\Errors;

class BadRequestError extends APIStatusError
{
    /** @var string */
    protected const DESC = 'Anthropic Bad Request Error';
}
