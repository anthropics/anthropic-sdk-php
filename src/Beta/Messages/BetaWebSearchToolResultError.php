<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

final class BetaWebSearchToolResultError implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'web_search_tool_result_error';

    /** @var BetaWebSearchToolResultErrorCode::* $errorCode */
    #[Api('error_code', enum: BetaWebSearchToolResultErrorCode::class)]
    public string $errorCode;

    /**
     * `new BetaWebSearchToolResultError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebSearchToolResultError::with(errorCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebSearchToolResultError)->withErrorCode(...)
     * ```
     */
    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaWebSearchToolResultErrorCode::* $errorCode
     */
    public static function with(string $errorCode): self
    {
        $obj = new self;

        $obj->errorCode = $errorCode;

        return $obj;
    }

    /**
     * @param BetaWebSearchToolResultErrorCode::* $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $obj = clone $this;
        $obj->errorCode = $errorCode;

        return $obj;
    }
}
