<?php

namespace Anthropic\Core\Exceptions;

class PaymentRequiredException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Anthropic Payment Required Exception';
}
