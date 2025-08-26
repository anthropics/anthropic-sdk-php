<?php

namespace Anthropic\Core\Errors;

class PermissionDeniedError extends APIStatusError
{
    /** @var string */
    protected const DESC = 'Anthropic Permission Denied Error';
}
