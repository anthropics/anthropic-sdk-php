<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultErrorObject\ErrorCode;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaBashCodeExecutionToolResultErrorObjectShape = array{
 *   errorCode: ErrorCode|value-of<ErrorCode>,
 *   type: 'bash_code_execution_tool_result_error',
 * }
 */
class BetaBashCodeExecutionToolResultErrorObject implements BaseModel
{
    /** @use SdkModel<BetaBashCodeExecutionToolResultErrorObjectShape> */
    use SdkModel;

    /** @var 'bash_code_execution_tool_result_error' $type */
    #[Required(type: new ConstantOf('bash_code_execution_tool_result_error'))]
    public string $type = 'bash_code_execution_tool_result_error';

    /** @var value-of<ErrorCode> $errorCode */
    #[Required('error_code', enum: ErrorCode::class)]
    public string $errorCode;

    /**
     * `new BetaBashCodeExecutionToolResultErrorObject()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBashCodeExecutionToolResultErrorObject::with(errorCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBashCodeExecutionToolResultErrorObject())->withErrorCode(...)
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
     * @param 'bash_code_execution_tool_result_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}

class_alias(
    BetaBashCodeExecutionToolResultErrorObject::class,
    'Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultError',
);
