<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_web_search_tool_request_error_alias = array{
 *   errorCode: BetaWebSearchToolResultErrorCode::*, type: string
 * }
 */
final class BetaWebSearchToolRequestError implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'web_search_tool_result_error';

    /** @var BetaWebSearchToolResultErrorCode::* $errorCode */
    #[Api('error_code', enum: BetaWebSearchToolResultErrorCode::class)]
    public string $errorCode;

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
    public static function from(string $errorCode): self
    {
        $obj = new self;

        $obj->errorCode = $errorCode;

        return $obj;
    }

    /**
     * @param BetaWebSearchToolResultErrorCode::* $errorCode
     */
    public function setErrorCode(string $errorCode): self
    {
        $this->errorCode = $errorCode;

        return $this;
    }
}
