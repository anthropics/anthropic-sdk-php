<?php

namespace Anthropic\Core\Exceptions;

class NotFoundException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Anthropic Not Found Exception';
}
