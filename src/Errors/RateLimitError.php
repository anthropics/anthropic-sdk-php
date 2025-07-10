<?php

namespace Anthropic\Errors;

class RateLimitError extends APIStatusError
{
    /** @var string */
    protected const DESC = 'Anthropic Rate Limit Error';
}
