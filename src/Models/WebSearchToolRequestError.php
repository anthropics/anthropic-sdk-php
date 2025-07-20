<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\WebSearchToolRequestError\ErrorCode;

/**
 * @phpstan-type web_search_tool_request_error_alias = array{
 *   errorCode: ErrorCode::*, type: string
 * }
 */
final class WebSearchToolRequestError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'web_search_tool_result_error';

    /** @var ErrorCode::* $errorCode */
    #[Api('error_code')]
    public string $errorCode;

    /**
     * You must use named parameters to construct this object.
     *
     * @param ErrorCode::* $errorCode
     */
    final public function __construct(string $errorCode)
    {
        self::introspect();

        $this->errorCode = $errorCode;
    }
}
