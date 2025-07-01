<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class ErrorResponse implements BaseModel
{
    use Model;

    /**
     * @var APIErrorObject|AuthenticationError|BillingError|GatewayTimeoutError|InvalidRequestError|NotFoundError|OverloadedError|PermissionError|RateLimitError $error
     */
    #[Api]
    public mixed $error;

    #[Api]
    public string $type;

    /**
     * @param APIErrorObject|AuthenticationError|BillingError|GatewayTimeoutError|InvalidRequestError|NotFoundError|OverloadedError|PermissionError|RateLimitError $error
     */
    final public function __construct(mixed $error, string $type)
    {
        $args = func_get_args();

        $data = [];
        for ($i = 0; $i < count($args); ++$i) {
            if (None::NOT_SET !== $args[$i]) {
                $data[self::$_constructorArgNames[$i]] = $args[$i] ?? null;
            }
        }

        $this->__unserialize($data);
    }
}

ErrorResponse::_loadMetadata();
