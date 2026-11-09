<?php

namespace Anthropic\Core\Exceptions;

class RequestTimeoutException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Anthropic Request Timeout Exception';
}
