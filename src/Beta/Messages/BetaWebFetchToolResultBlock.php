<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_web_fetch_tool_result_block = array{
 *   content: BetaWebFetchToolResultErrorBlock|BetaWebFetchBlock,
 *   toolUseID: string,
 *   type: string,
 * }
 */
final class BetaWebFetchToolResultBlock implements BaseModel
{
    /** @use SdkModel<beta_web_fetch_tool_result_block> */
    use SdkModel;

    #[Api]
    public string $type = 'web_fetch_tool_result';

    #[Api]
    public BetaWebFetchToolResultErrorBlock|BetaWebFetchBlock $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * `new BetaWebFetchToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebFetchToolResultBlock::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebFetchToolResultBlock)->withContent(...)->withToolUseID(...)
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
     */
    public static function with(
        BetaWebFetchToolResultErrorBlock|BetaWebFetchBlock $content,
        string $toolUseID,
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }

    public function withContent(
        BetaWebFetchToolResultErrorBlock|BetaWebFetchBlock $content
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
