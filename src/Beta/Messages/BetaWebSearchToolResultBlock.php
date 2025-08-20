<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
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
    use SdkModel;

    #[Api]
    public string $type = 'web_search_tool_result';

    /** @var BetaWebSearchToolResultError|list<BetaWebSearchResultBlock> $content */
    #[Api(union: BetaWebSearchToolResultBlockContent::class)]
    public array|BetaWebSearchToolResultError $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * `new BetaWebSearchToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebSearchToolResultBlock::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebSearchToolResultBlock)->withContent(...)->withToolUseID(...)
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
     * @param BetaWebSearchToolResultError|list<BetaWebSearchResultBlock> $content
     */
    public static function with(
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
    public function withContent(
        array|BetaWebSearchToolResultError $content
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
