<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\BetaGatewayTimeoutError\Type;

final class BetaGatewayTimeoutError implements BaseModel
{
    use Model;

    #[Api]
    public string $message = 'Request timeout';

    /** @var Type::* $type */
    #[Api]
    public string $type = 'timeout_error';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $message = 'Request timeout',
        string $type = 'timeout_error'
    ) {
        $this->message = $message;
        $this->type = $type;
    }
}

BetaGatewayTimeoutError::_loadMetadata();
