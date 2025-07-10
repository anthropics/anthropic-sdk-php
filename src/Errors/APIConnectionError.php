<?php

namespace Anthropic\Errors;

class APIConnectionError extends APIError
{
    /** @var string */
    protected const DESC = 'Anthropic API Connection Error';
}
