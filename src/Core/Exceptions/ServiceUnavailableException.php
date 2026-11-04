<?php

namespace Anthropic\Core\Exceptions;

class ServiceUnavailableException extends InternalServerException
{
    /** @var string */
    protected const DESC = 'Anthropic Service Unavailable Exception';
}
