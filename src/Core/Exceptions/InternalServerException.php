<?php

namespace Anthropic\Core\Exceptions;

class InternalServerException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Anthropic Internal Server Exception';
}
