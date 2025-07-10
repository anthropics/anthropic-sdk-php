<?php

namespace Anthropic\Errors;

class NotFoundError extends APIStatusError
{
    /** @var string */
    protected const DESC = 'Anthropic Not Found Error';
}
