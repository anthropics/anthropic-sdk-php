<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\WebSearchToolRequestError\ErrorCode;
use Anthropic\Models\WebSearchToolRequestError\Type;

final class WebSearchToolRequestError implements BaseModel
{
    use Model;

    /** @var ErrorCode::* $errorCode */
    #[Api('error_code')]
    public string $errorCode;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object.
     *
     * @param ErrorCode::* $errorCode
     * @param Type::*      $type
     */
    final public function __construct(string $errorCode, string $type)
    {
        $this->errorCode = $errorCode;
        $this->type = $type;
    }
}

WebSearchToolRequestError::_loadMetadata();
