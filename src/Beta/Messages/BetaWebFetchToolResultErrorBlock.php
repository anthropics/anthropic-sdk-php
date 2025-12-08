<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebFetchToolResultErrorBlockShape = array{
 *   error_code: value-of<BetaWebFetchToolResultErrorCode>,
 *   type: 'web_fetch_tool_result_error',
 * }
 */
final class BetaWebFetchToolResultErrorBlock implements BaseModel
{
    /** @use SdkModel<BetaWebFetchToolResultErrorBlockShape> */
    use SdkModel;

    /** @var 'web_fetch_tool_result_error' $type */
    #[Required]
    public string $type = 'web_fetch_tool_result_error';

    /** @var value-of<BetaWebFetchToolResultErrorCode> $error_code */
    #[Required(enum: BetaWebFetchToolResultErrorCode::class)]
    public string $error_code;

    /**
     * `new BetaWebFetchToolResultErrorBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebFetchToolResultErrorBlock::with(error_code: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebFetchToolResultErrorBlock)->withErrorCode(...)
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
     * @param BetaWebFetchToolResultErrorCode|value-of<BetaWebFetchToolResultErrorCode> $error_code
     */
    public static function with(
        BetaWebFetchToolResultErrorCode|string $error_code
    ): self {
        $obj = new self;

        $obj['error_code'] = $error_code;

        return $obj;
    }

    /**
     * @param BetaWebFetchToolResultErrorCode|value-of<BetaWebFetchToolResultErrorCode> $errorCode
     */
    public function withErrorCode(
        BetaWebFetchToolResultErrorCode|string $errorCode
    ): self {
        $obj = clone $this;
        $obj['error_code'] = $errorCode;

        return $obj;
    }
}
