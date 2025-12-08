<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaToolSearchToolResultError\ErrorCode;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolSearchToolResultErrorShape = array{
 *   error_code: value-of<ErrorCode>,
 *   error_message: string|null,
 *   type: 'tool_search_tool_result_error',
 * }
 */
final class BetaToolSearchToolResultError implements BaseModel
{
    /** @use SdkModel<BetaToolSearchToolResultErrorShape> */
    use SdkModel;

    /** @var 'tool_search_tool_result_error' $type */
    #[Required]
    public string $type = 'tool_search_tool_result_error';

    /** @var value-of<ErrorCode> $error_code */
    #[Required(enum: ErrorCode::class)]
    public string $error_code;

    #[Required]
    public ?string $error_message;

    /**
     * `new BetaToolSearchToolResultError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolSearchToolResultError::with(error_code: ..., error_message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolSearchToolResultError)->withErrorCode(...)->withErrorMessage(...)
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
     * @param ErrorCode|value-of<ErrorCode> $error_code
     */
    public static function with(
        ErrorCode|string $error_code,
        ?string $error_message
    ): self {
        $obj = new self;

        $obj['error_code'] = $error_code;
        $obj['error_message'] = $error_message;

        return $obj;
    }

    /**
     * @param ErrorCode|value-of<ErrorCode> $errorCode
     */
    public function withErrorCode(ErrorCode|string $errorCode): self
    {
        $obj = clone $this;
        $obj['error_code'] = $errorCode;

        return $obj;
    }

    public function withErrorMessage(?string $errorMessage): self
    {
        $obj = clone $this;
        $obj['error_message'] = $errorMessage;

        return $obj;
    }
}
