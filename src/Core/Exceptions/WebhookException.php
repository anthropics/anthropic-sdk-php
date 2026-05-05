<?php

namespace Anthropic\Core\Exceptions;

class WebhookException extends AnthropicException
{
    /** @var string */
    protected const DESC = 'Anthropic Webhook Exception';
}
