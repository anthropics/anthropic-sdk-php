<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_code_execution_tool_result_block_alias = array{
 *   content: BetaCodeExecutionToolResultError|BetaCodeExecutionResultBlock,
 *   toolUseID: string,
 *   type: string,
 * }
 */
final class BetaCodeExecutionToolResultBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'code_execution_tool_result';

    #[Api]
    public BetaCodeExecutionResultBlock|BetaCodeExecutionToolResultError $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * `new BetaCodeExecutionToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCodeExecutionToolResultBlock::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCodeExecutionToolResultBlock)->withContent(...)->withToolUseID(...)
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
     */
    public static function with(
        BetaCodeExecutionResultBlock|BetaCodeExecutionToolResultError $content,
        string $toolUseID,
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }

    public function withContent(
        BetaCodeExecutionResultBlock|BetaCodeExecutionToolResultError $content
    ): self {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }
}
