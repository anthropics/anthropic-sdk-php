<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BashCodeExecutionToolResultErrorParamShape = array{
 *   errorCode: BashCodeExecutionToolResultErrorCode|value-of<BashCodeExecutionToolResultErrorCode>,
 *   type: 'bash_code_execution_tool_result_error',
 * }
 */
final class BashCodeExecutionToolResultErrorParam implements BaseModel
{
    /** @use SdkModel<BashCodeExecutionToolResultErrorParamShape> */
    use SdkModel;

    /** @var 'bash_code_execution_tool_result_error' $type */
    #[Required]
    public string $type = 'bash_code_execution_tool_result_error';

    /** @var value-of<BashCodeExecutionToolResultErrorCode> $errorCode */
    #[Required('error_code', enum: BashCodeExecutionToolResultErrorCode::class)]
    public string $errorCode;

    /**
     * `new BashCodeExecutionToolResultErrorParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BashCodeExecutionToolResultErrorParam::with(errorCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BashCodeExecutionToolResultErrorParam)->withErrorCode(...)
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
     * @param BashCodeExecutionToolResultErrorCode|value-of<BashCodeExecutionToolResultErrorCode> $errorCode
     */
    public static function with(
        BashCodeExecutionToolResultErrorCode|string $errorCode
    ): self {
        $self = new self;

        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * @param BashCodeExecutionToolResultErrorCode|value-of<BashCodeExecutionToolResultErrorCode> $errorCode
     */
    public function withErrorCode(
        BashCodeExecutionToolResultErrorCode|string $errorCode
    ): self {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * @param 'bash_code_execution_tool_result_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
