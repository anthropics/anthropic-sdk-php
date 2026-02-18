<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type WebSearchToolRequestErrorShape = array{
 *   errorCode: WebSearchToolResultErrorCode|value-of<WebSearchToolResultErrorCode>,
 *   type: 'web_search_tool_result_error',
 * }
 */
final class WebSearchToolRequestError implements BaseModel
{
    /** @use SdkModel<WebSearchToolRequestErrorShape> */
    use SdkModel;

    /** @var 'web_search_tool_result_error' $type */
    #[Required]
    public string $type = 'web_search_tool_result_error';

    /** @var value-of<WebSearchToolResultErrorCode> $errorCode */
    #[Required('error_code', enum: WebSearchToolResultErrorCode::class)]
    public string $errorCode;

    /**
     * `new WebSearchToolRequestError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebSearchToolRequestError::with(errorCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebSearchToolRequestError)->withErrorCode(...)
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
     * @param WebSearchToolResultErrorCode|value-of<WebSearchToolResultErrorCode> $errorCode
     */
    public static function with(
        WebSearchToolResultErrorCode|string $errorCode
    ): self {
        $self = new self;

        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * @param WebSearchToolResultErrorCode|value-of<WebSearchToolResultErrorCode> $errorCode
     */
    public function withErrorCode(
        WebSearchToolResultErrorCode|string $errorCode
    ): self {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * @param 'web_search_tool_result_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
