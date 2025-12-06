<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaToolSearchToolResultError\ErrorCode;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolSearchToolResultBlockShape = array{
 *   content: BetaToolSearchToolResultError|BetaToolSearchToolSearchResultBlock,
 *   tool_use_id: string,
 *   type: 'tool_search_tool_result',
 * }
 */
final class BetaToolSearchToolResultBlock implements BaseModel
{
    /** @use SdkModel<BetaToolSearchToolResultBlockShape> */
    use SdkModel;

    /** @var 'tool_search_tool_result' $type */
    #[Api]
    public string $type = 'tool_search_tool_result';

    #[Api]
    public BetaToolSearchToolResultError|BetaToolSearchToolSearchResultBlock $content;

    #[Api]
    public string $tool_use_id;

    /**
     * `new BetaToolSearchToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolSearchToolResultBlock::with(content: ..., tool_use_id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolSearchToolResultBlock)->withContent(...)->withToolUseID(...)
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
     * @param BetaToolSearchToolResultError|array{
     *   error_code: value-of<ErrorCode>,
     *   error_message: string|null,
     *   type: 'tool_search_tool_result_error',
     * }|BetaToolSearchToolSearchResultBlock|array{
     *   tool_references: list<BetaToolReferenceBlock>,
     *   type: 'tool_search_tool_search_result',
     * } $content
     */
    public static function with(
        BetaToolSearchToolResultError|array|BetaToolSearchToolSearchResultBlock $content,
        string $tool_use_id,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['tool_use_id'] = $tool_use_id;

        return $obj;
    }

    /**
     * @param BetaToolSearchToolResultError|array{
     *   error_code: value-of<ErrorCode>,
     *   error_message: string|null,
     *   type: 'tool_search_tool_result_error',
     * }|BetaToolSearchToolSearchResultBlock|array{
     *   tool_references: list<BetaToolReferenceBlock>,
     *   type: 'tool_search_tool_search_result',
     * } $content
     */
    public function withContent(
        BetaToolSearchToolResultError|array|BetaToolSearchToolSearchResultBlock $content,
    ): self {
        $obj = clone $this;
        $obj['content'] = $content;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj['tool_use_id'] = $toolUseID;

        return $obj;
    }
}
