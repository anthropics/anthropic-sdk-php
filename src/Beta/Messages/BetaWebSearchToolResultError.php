<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebSearchToolResultErrorShape = array{
 *   error_code: value-of<BetaWebSearchToolResultErrorCode>,
 *   type: 'web_search_tool_result_error',
 * }
 */
final class BetaWebSearchToolResultError implements BaseModel
{
    /** @use SdkModel<BetaWebSearchToolResultErrorShape> */
    use SdkModel;

    /** @var 'web_search_tool_result_error' $type */
    #[Required]
    public string $type = 'web_search_tool_result_error';

    /** @var value-of<BetaWebSearchToolResultErrorCode> $error_code */
    #[Required(enum: BetaWebSearchToolResultErrorCode::class)]
    public string $error_code;

    /**
     * `new BetaWebSearchToolResultError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebSearchToolResultError::with(error_code: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebSearchToolResultError)->withErrorCode(...)
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
     * @param BetaWebSearchToolResultErrorCode|value-of<BetaWebSearchToolResultErrorCode> $error_code
     */
    public static function with(
        BetaWebSearchToolResultErrorCode|string $error_code
    ): self {
        $obj = new self;

        $obj['error_code'] = $error_code;

        return $obj;
    }

    /**
     * @param BetaWebSearchToolResultErrorCode|value-of<BetaWebSearchToolResultErrorCode> $errorCode
     */
    public function withErrorCode(
        BetaWebSearchToolResultErrorCode|string $errorCode
    ): self {
        $obj = clone $this;
        $obj['error_code'] = $errorCode;

        return $obj;
    }
}
