<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaWebSearchToolRequestErrorObjectShape = array{
 *   errorCode: BetaWebSearchToolResultErrorCode|value-of<BetaWebSearchToolResultErrorCode>,
 *   type: 'web_search_tool_result_error',
 * }
 */
class BetaWebSearchToolRequestErrorObject implements BaseModel
{
    /** @use SdkModel<BetaWebSearchToolRequestErrorObjectShape> */
    use SdkModel;

    /** @var 'web_search_tool_result_error' $type */
    #[Required(type: new ConstantOf('web_search_tool_result_error'))]
    public string $type = 'web_search_tool_result_error';

    /** @var value-of<BetaWebSearchToolResultErrorCode> $errorCode */
    #[Required('error_code', enum: BetaWebSearchToolResultErrorCode::class)]
    public string $errorCode;

    /**
     * `new BetaWebSearchToolRequestErrorObject()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebSearchToolRequestErrorObject::with(errorCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebSearchToolRequestErrorObject())->withErrorCode(...)
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
     * @param BetaWebSearchToolResultErrorCode|value-of<BetaWebSearchToolResultErrorCode> $errorCode
     */
    public static function with(
        BetaWebSearchToolResultErrorCode|string $errorCode
    ): self {
        $self = new self;

        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * @param BetaWebSearchToolResultErrorCode|value-of<BetaWebSearchToolResultErrorCode> $errorCode
     */
    public function withErrorCode(
        BetaWebSearchToolResultErrorCode|string $errorCode
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

class_alias(
    BetaWebSearchToolRequestErrorObject::class,
    'Anthropic\Beta\Messages\BetaWebSearchToolRequestError',
);
