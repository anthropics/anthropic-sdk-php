<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ToolSearchToolResultErrorShape = array{
 *   errorCode: ToolSearchToolResultErrorCode|value-of<ToolSearchToolResultErrorCode>,
 *   errorMessage: string|null,
 *   type: 'tool_search_tool_result_error',
 * }
 */
final class ToolSearchToolResultError implements BaseModel
{
    /** @use SdkModel<ToolSearchToolResultErrorShape> */
    use SdkModel;

    /** @var 'tool_search_tool_result_error' $type */
    #[Required]
    public string $type = 'tool_search_tool_result_error';

    /** @var value-of<ToolSearchToolResultErrorCode> $errorCode */
    #[Required('error_code', enum: ToolSearchToolResultErrorCode::class)]
    public string $errorCode;

    #[Required('error_message')]
    public ?string $errorMessage;

    /**
     * `new ToolSearchToolResultError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolSearchToolResultError::with(errorCode: ..., errorMessage: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolSearchToolResultError)->withErrorCode(...)->withErrorMessage(...)
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
        ToolSearchToolResultErrorCode|string $errorCode,
        ?string $errorMessage
    ): self {
        $self = new self;

        $self['errorCode'] = $errorCode;
        $self['errorMessage'] = $errorMessage;

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

    public function withErrorMessage(?string $errorMessage): self
    {
        $self = clone $this;
        $self['errorMessage'] = $errorMessage;

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
