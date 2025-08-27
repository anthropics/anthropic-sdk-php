<?php

namespace Anthropic\Core\Exceptions;

class APIConnectionException extends APIException
{
    /** @var string */
    protected const DESC = 'Anthropic API Connection Error';
}
