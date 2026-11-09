<?php

namespace Anthropic\Core\Exceptions;

class RequestHeaderFieldsTooLargeException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Anthropic Request Header Fields Too Large Exception';
}
