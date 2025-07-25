<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

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
    public static function new(
        BetaCodeExecutionResultBlock|BetaCodeExecutionToolResultError $content,
        string $toolUseID,
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }

    public function setContent(
        BetaCodeExecutionResultBlock|BetaCodeExecutionToolResultError $content
    ): self {
        $this->content = $content;

        return $this;
    }

    public function setToolUseID(string $toolUseID): self
    {
        $this->toolUseID = $toolUseID;

        return $this;
    }
}
