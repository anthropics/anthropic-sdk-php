<?php

namespace Anthropic\Core\Exceptions;

class ClientClosedRequestException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Anthropic Client Closed Request Exception';
}
