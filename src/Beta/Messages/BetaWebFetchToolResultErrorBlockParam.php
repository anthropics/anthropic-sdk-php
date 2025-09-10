<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_web_fetch_tool_result_error_block_param = array{
 *   errorCode: BetaWebFetchToolResultErrorCode::*, type: string
 * }
 */
final class BetaWebFetchToolResultErrorBlockParam implements BaseModel
{
    /** @use SdkModel<beta_web_fetch_tool_result_error_block_param> */
    use SdkModel;

    #[Api]
    public string $type = 'web_fetch_tool_result_error';

    /** @var BetaWebFetchToolResultErrorCode::* $errorCode */
    #[Api('error_code', enum: BetaWebFetchToolResultErrorCode::class)]
    public string $errorCode;

    /**
     * `new BetaWebFetchToolResultErrorBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebFetchToolResultErrorBlockParam::with(errorCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebFetchToolResultErrorBlockParam)->withErrorCode(...)
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
     * @param BetaWebFetchToolResultErrorCode::* $errorCode
     */
    public static function with(string $errorCode): self
    {
        $obj = new self;

        $obj->errorCode = $errorCode;

        return $obj;
    }

    /**
     * @param BetaWebFetchToolResultErrorCode::* $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $obj = clone $this;
        $obj->errorCode = $errorCode;

        return $obj;
    }
}
