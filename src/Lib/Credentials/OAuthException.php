<?php

declare(strict_types=1);

namespace Anthropic\Lib\Credentials;

use Anthropic\Core\Exceptions\AnthropicException;

class OAuthException extends AnthropicException
{
    /** @var string */
    protected const DESC = 'Anthropic OAuth Error';

    public function __construct(
        public readonly int $statusCode,
        string $message,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $statusCode, $previous);
    }
}
