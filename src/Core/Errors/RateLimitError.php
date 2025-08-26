<?php

namespace Anthropic\Core\Errors;

class RateLimitError extends APIStatusError
{
    /** @var string */
    protected const DESC = 'Anthropic Rate Limit Error';
}
