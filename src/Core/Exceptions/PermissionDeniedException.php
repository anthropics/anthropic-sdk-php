<?php

namespace Anthropic\Core\Exceptions;

class PermissionDeniedException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Anthropic Permission Denied Exception';
}
