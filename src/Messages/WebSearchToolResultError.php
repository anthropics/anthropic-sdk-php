<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\WebSearchToolResultError\ErrorCode;

/**
 * @phpstan-type web_search_tool_result_error_alias = array{
 *   errorCode: ErrorCode::*, type: string
 * }
 */
final class WebSearchToolResultError implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'web_search_tool_result_error';

    /** @var ErrorCode::* $errorCode */
    #[Api('error_code', enum: ErrorCode::class)]
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
     * @param ErrorCode::* $errorCode
     */
    public static function new(string $errorCode): self
    {
        $obj = new self;

        $obj->errorCode = $errorCode;

        return $obj;
    }

    /**
     * @param ErrorCode::* $errorCode
     */
    public function setErrorCode(string $errorCode): self
    {
        $this->errorCode = $errorCode;

        return $this;
    }
}
