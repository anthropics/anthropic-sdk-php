<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\WebSearchToolRequestError\ErrorCode;

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
    #[Api('error_code', enum: ErrorCode::class)]
    public string $errorCode;

    /**
     * `new WebSearchToolRequestError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebSearchToolRequestError::with(errorCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebSearchToolRequestError)->withErrorCode(...)
     * ```
     */
    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ErrorCode::* $errorCode
     */
    public static function with(string $errorCode): self
    {
        $obj = new self;

        $obj->errorCode = $errorCode;

        return $obj;
    }

    /**
     * @param ErrorCode::* $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $obj = clone $this;
        $obj->errorCode = $errorCode;

        return $obj;
    }
}
