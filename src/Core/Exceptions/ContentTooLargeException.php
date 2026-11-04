<?php

namespace Anthropic\Core\Exceptions;

class ContentTooLargeException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Anthropic Content Too Large Exception';
}
