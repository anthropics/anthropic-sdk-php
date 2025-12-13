<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaToolSearchToolResultError\ErrorCode;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolSearchToolResultErrorShape = array{
 *   errorCode: value-of<ErrorCode>,
 *   errorMessage: string|null,
 *   type?: 'tool_search_tool_result_error',
 * }
 */
final class BetaToolSearchToolResultError implements BaseModel
{
    /** @use SdkModel<BetaToolSearchToolResultErrorShape> */
    use SdkModel;

    /** @var 'tool_search_tool_result_error' $type */
    #[Required]
    public string $type = 'tool_search_tool_result_error';

    /** @var value-of<ErrorCode> $errorCode */
    #[Required('error_code', enum: ErrorCode::class)]
    public string $errorCode;

    #[Required('error_message')]
    public ?string $errorMessage;

    /**
     * `new BetaToolSearchToolResultError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolSearchToolResultError::with(errorCode: ..., errorMessage: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolSearchToolResultError)->withErrorCode(...)->withErrorMessage(...)
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
    public static function with(
        ErrorCode|string $errorCode,
        ?string $errorMessage
    ): self {
        $self = new self;

        $self['errorCode'] = $errorCode;
        $self['errorMessage'] = $errorMessage;

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

    public function withErrorMessage(?string $errorMessage): self
    {
        $self = clone $this;
        $self['errorMessage'] = $errorMessage;

        return $self;
    }
}
