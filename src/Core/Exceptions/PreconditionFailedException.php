<?php

namespace Anthropic\Core\Exceptions;

class PreconditionFailedException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Anthropic Precondition Failed Exception';
}
