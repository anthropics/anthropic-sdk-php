<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ToolSearchToolResultErrorParamShape = array{
 *   errorCode: ToolSearchToolResultErrorCode|value-of<ToolSearchToolResultErrorCode>,
 *   type: 'tool_search_tool_result_error',
 * }
 */
final class ToolSearchToolResultErrorParam implements BaseModel
{
    /** @use SdkModel<ToolSearchToolResultErrorParamShape> */
    use SdkModel;

    /** @var 'tool_search_tool_result_error' $type */
    #[Required]
    public string $type = 'tool_search_tool_result_error';

    /** @var value-of<ToolSearchToolResultErrorCode> $errorCode */
    #[Required('error_code', enum: ToolSearchToolResultErrorCode::class)]
    public string $errorCode;

    /**
     * `new ToolSearchToolResultErrorParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolSearchToolResultErrorParam::with(errorCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolSearchToolResultErrorParam)->withErrorCode(...)
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
     * @param ToolSearchToolResultErrorCode|value-of<ToolSearchToolResultErrorCode> $errorCode
     */
    public static function with(
        ToolSearchToolResultErrorCode|string $errorCode
    ): self {
        $self = new self;

        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * @param ToolSearchToolResultErrorCode|value-of<ToolSearchToolResultErrorCode> $errorCode
     */
    public function withErrorCode(
        ToolSearchToolResultErrorCode|string $errorCode
    ): self {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * @param 'tool_search_tool_result_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
