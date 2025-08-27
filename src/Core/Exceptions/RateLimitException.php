<?php

namespace Anthropic\Core\Exceptions;

class RateLimitException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Anthropic Rate Limit Exception';
}
