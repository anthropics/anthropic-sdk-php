<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type WebFetchToolResultErrorBlockShape = array{
 *   errorCode: WebFetchToolResultErrorCode|value-of<WebFetchToolResultErrorCode>,
 *   type: 'web_fetch_tool_result_error',
 * }
 */
final class WebFetchToolResultErrorBlock implements BaseModel
{
    /** @use SdkModel<WebFetchToolResultErrorBlockShape> */
    use SdkModel;

    /** @var 'web_fetch_tool_result_error' $type */
    #[Required]
    public string $type = 'web_fetch_tool_result_error';

    /** @var value-of<WebFetchToolResultErrorCode> $errorCode */
    #[Required('error_code', enum: WebFetchToolResultErrorCode::class)]
    public string $errorCode;

    /**
     * `new WebFetchToolResultErrorBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebFetchToolResultErrorBlock::with(errorCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebFetchToolResultErrorBlock)->withErrorCode(...)
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
     * @param WebFetchToolResultErrorCode|value-of<WebFetchToolResultErrorCode> $errorCode
     */
    public static function with(
        WebFetchToolResultErrorCode|string $errorCode
    ): self {
        $self = new self;

        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * @param WebFetchToolResultErrorCode|value-of<WebFetchToolResultErrorCode> $errorCode
     */
    public function withErrorCode(
        WebFetchToolResultErrorCode|string $errorCode
    ): self {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * @param 'web_fetch_tool_result_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
