<?php

namespace Anthropic\Core\Exceptions;

class OverloadedException extends InternalServerException
{
    /** @var string */
    protected const DESC = 'Anthropic Overloaded Exception';
}
