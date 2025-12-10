<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaToolSearchToolResultErrorParam\ErrorCode;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolSearchToolResultErrorParamShape = array{
 *   errorCode: value-of<ErrorCode>, type?: 'tool_search_tool_result_error'
 * }
 */
final class BetaToolSearchToolResultErrorParam implements BaseModel
{
    /** @use SdkModel<BetaToolSearchToolResultErrorParamShape> */
    use SdkModel;

    /** @var 'tool_search_tool_result_error' $type */
    #[Required]
    public string $type = 'tool_search_tool_result_error';

    /** @var value-of<ErrorCode> $errorCode */
    #[Required('error_code', enum: ErrorCode::class)]
    public string $errorCode;

    /**
     * `new BetaToolSearchToolResultErrorParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolSearchToolResultErrorParam::with(errorCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolSearchToolResultErrorParam)->withErrorCode(...)
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
