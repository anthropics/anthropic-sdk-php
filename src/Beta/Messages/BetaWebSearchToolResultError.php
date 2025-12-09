<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebSearchToolResultErrorShape = array{
 *   errorCode: value-of<BetaWebSearchToolResultErrorCode>,
 *   type?: 'web_search_tool_result_error',
 * }
 */
final class BetaWebSearchToolResultError implements BaseModel
{
    /** @use SdkModel<BetaWebSearchToolResultErrorShape> */
    use SdkModel;

    /** @var 'web_search_tool_result_error' $type */
    #[Required]
    public string $type = 'web_search_tool_result_error';

    /** @var value-of<BetaWebSearchToolResultErrorCode> $errorCode */
    #[Required('error_code', enum: BetaWebSearchToolResultErrorCode::class)]
    public string $errorCode;

    /**
     * `new BetaWebSearchToolResultError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebSearchToolResultError::with(errorCode: ...)
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
     * @param BetaWebSearchToolResultErrorCode|value-of<BetaWebSearchToolResultErrorCode> $errorCode
     */
    public static function with(
        BetaWebSearchToolResultErrorCode|string $errorCode
    ): self {
        $obj = new self;

        $obj['errorCode'] = $errorCode;

        return $obj;
    }

    /**
     * @param BetaWebSearchToolResultErrorCode|value-of<BetaWebSearchToolResultErrorCode> $errorCode
     */
    public function withErrorCode(
        BetaWebSearchToolResultErrorCode|string $errorCode
    ): self {
        $obj = clone $this;
        $obj['errorCode'] = $errorCode;

        return $obj;
    }
}
