<?php

namespace Anthropic\Core\Exceptions;

class GatewayTimeoutException extends InternalServerException
{
    /** @var string */
    protected const DESC = 'Anthropic Gateway Timeout Exception';
}
