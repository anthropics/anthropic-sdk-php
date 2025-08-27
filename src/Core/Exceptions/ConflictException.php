<?php

namespace Anthropic\Core\Exceptions;

class ConflictException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Anthropic Conflict Exception';
}
