<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_web_search_tool_result_block_alias = array{
 *   content: BetaWebSearchToolResultError|list<BetaWebSearchResultBlock>,
 *   toolUseID: string,
 *   type: string,
 * }
 */
final class BetaWebSearchToolResultBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'web_search_tool_result';

    /** @var BetaWebSearchToolResultError|list<BetaWebSearchResultBlock> $content */
    #[Api(union: BetaWebSearchToolResultBlockContent::class)]
    public array|BetaWebSearchToolResultError $content;

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
     *
     * @param BetaWebSearchToolResultError|list<BetaWebSearchResultBlock> $content
     */
    public static function new(
        array|BetaWebSearchToolResultError $content,
        string $toolUseID
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }

    /**
     * @param BetaWebSearchToolResultError|list<BetaWebSearchResultBlock> $content
     */
    public function setContent(
        array|BetaWebSearchToolResultError $content
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
