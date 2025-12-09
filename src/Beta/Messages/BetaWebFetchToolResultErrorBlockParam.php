<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebFetchToolResultErrorBlockParamShape = array{
 *   errorCode: value-of<BetaWebFetchToolResultErrorCode>,
 *   type?: 'web_fetch_tool_result_error',
 * }
 */
final class BetaWebFetchToolResultErrorBlockParam implements BaseModel
{
    /** @use SdkModel<BetaWebFetchToolResultErrorBlockParamShape> */
    use SdkModel;

    /** @var 'web_fetch_tool_result_error' $type */
    #[Required]
    public string $type = 'web_fetch_tool_result_error';

    /** @var value-of<BetaWebFetchToolResultErrorCode> $errorCode */
    #[Required('error_code', enum: BetaWebFetchToolResultErrorCode::class)]
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
     * @param BetaWebFetchToolResultErrorCode|value-of<BetaWebFetchToolResultErrorCode> $errorCode
     */
    public static function with(
        BetaWebFetchToolResultErrorCode|string $errorCode
    ): self {
        $self = new self;

        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * @param BetaWebFetchToolResultErrorCode|value-of<BetaWebFetchToolResultErrorCode> $errorCode
     */
    public function withErrorCode(
        BetaWebFetchToolResultErrorCode|string $errorCode
    ): self {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
