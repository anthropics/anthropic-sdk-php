<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_web_fetch_tool_result_error_block = array{
 *   errorCode: value-of<BetaWebFetchToolResultErrorCode>, type: string
 * }
 */
final class BetaWebFetchToolResultErrorBlock implements BaseModel
{
    /** @use SdkModel<beta_web_fetch_tool_result_error_block> */
    use SdkModel;

    #[Api]
    public string $type = 'web_fetch_tool_result_error';

    /** @var value-of<BetaWebFetchToolResultErrorCode> $errorCode */
    #[Api('error_code', enum: BetaWebFetchToolResultErrorCode::class)]
    public string $errorCode;

    /**
     * `new BetaWebFetchToolResultErrorBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebFetchToolResultErrorBlock::with(errorCode: ...)
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
     * @param BetaWebFetchToolResultErrorCode|value-of<BetaWebFetchToolResultErrorCode> $errorCode
     */
    public static function with(
        BetaWebFetchToolResultErrorCode|string $errorCode
    ): self {
        $obj = new self;

        $obj->errorCode = $errorCode instanceof BetaWebFetchToolResultErrorCode ? $errorCode->value : $errorCode;

        return $obj;
    }

    /**
     * @param BetaWebFetchToolResultErrorCode|value-of<BetaWebFetchToolResultErrorCode> $errorCode
     */
    public function withErrorCode(
        BetaWebFetchToolResultErrorCode|string $errorCode
    ): self {
        $obj = clone $this;
        $obj->errorCode = $errorCode instanceof BetaWebFetchToolResultErrorCode ? $errorCode->value : $errorCode;

        return $obj;
    }
}
