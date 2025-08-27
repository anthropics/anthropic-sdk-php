<?php

namespace Anthropic\Core\Exceptions;

class UnprocessableEntityException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Anthropic Unprocessable Entity Exception';
}
