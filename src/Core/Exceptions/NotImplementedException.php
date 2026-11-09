<?php

namespace Anthropic\Core\Exceptions;

class NotImplementedException extends InternalServerException
{
    /** @var string */
    protected const DESC = 'Anthropic Not Implemented Exception';
}
