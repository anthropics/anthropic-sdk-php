<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaAdvisorToolResultErrorParam\ErrorCode;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaAdvisorToolResultErrorParamShape = array{
 *   errorCode: ErrorCode|value-of<ErrorCode>, type: 'advisor_tool_result_error'
 * }
 */
final class BetaAdvisorToolResultErrorParam implements BaseModel
{
    /** @use SdkModel<BetaAdvisorToolResultErrorParamShape> */
    use SdkModel;

    /** @var 'advisor_tool_result_error' $type */
    #[Required]
    public string $type = 'advisor_tool_result_error';

    /** @var value-of<ErrorCode> $errorCode */
    #[Required('error_code', enum: ErrorCode::class)]
    public string $errorCode;

    /**
     * `new BetaAdvisorToolResultErrorParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAdvisorToolResultErrorParam::with(errorCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAdvisorToolResultErrorParam)->withErrorCode(...)
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
        $self = new self;

        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * @param ErrorCode|value-of<ErrorCode> $errorCode
     */
    public function withErrorCode(ErrorCode|string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * @param 'advisor_tool_result_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
