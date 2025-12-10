<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\WebSearchToolResultError\ErrorCode;

/**
 * @phpstan-type WebSearchToolResultErrorShape = array{
 *   errorCode: value-of<ErrorCode>, type?: 'web_search_tool_result_error'
 * }
 */
final class WebSearchToolResultError implements BaseModel
{
    /** @use SdkModel<WebSearchToolResultErrorShape> */
    use SdkModel;

    /** @var 'web_search_tool_result_error' $type */
    #[Required]
    public string $type = 'web_search_tool_result_error';

    /** @var value-of<ErrorCode> $errorCode */
    #[Required('error_code', enum: ErrorCode::class)]
    public string $errorCode;

    /**
     * `new WebSearchToolResultError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebSearchToolResultError::with(errorCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebSearchToolResultError)->withErrorCode(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ErrorCode|value-of<ErrorCode> $errorCode
     */
    public static function with(ErrorCode|string $errorCode): self
    {
        $obj = new self;

        $obj['errorCode'] = $errorCode;

        return $obj;
    }

    /**
     * @param ErrorCode|value-of<ErrorCode> $errorCode
     */
    public function withErrorCode(ErrorCode|string $errorCode): self
    {
        $obj = clone $this;
        $obj['errorCode'] = $errorCode;

        return $obj;
    }
}
