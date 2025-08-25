<?php

namespace Anthropic\Core\Errors;

class NotFoundError extends APIStatusError
{
    /** @var string */
    protected const DESC = 'Anthropic Not Found Error';
}
