<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\BetaAPIError\Type;

final class BetaAPIError implements BaseModel
{
    use Model;

    #[Api]
    public string $message = 'Internal server error';

    /** @var Type::* $type */
    #[Api]
    public string $type = 'api_error';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $message = 'Internal server error',
        string $type = 'api_error'
    ) {
        $this->message = $message;
        $this->type = $type;
    }
}

BetaAPIError::_loadMetadata();
