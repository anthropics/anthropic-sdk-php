<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebFetchToolResultBlockShape = array{
 *   content: BetaWebFetchToolResultErrorBlock|BetaWebFetchBlock,
 *   tool_use_id: string,
 *   type: 'web_fetch_tool_result',
 * }
 */
final class BetaWebFetchToolResultBlock implements BaseModel
{
    /** @use SdkModel<BetaWebFetchToolResultBlockShape> */
    use SdkModel;

    /** @var 'web_fetch_tool_result' $type */
    #[Api]
    public string $type = 'web_fetch_tool_result';

    #[Api]
    public BetaWebFetchToolResultErrorBlock|BetaWebFetchBlock $content;

    #[Api]
    public string $tool_use_id;

    /**
     * `new BetaWebFetchToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebFetchToolResultBlock::with(content: ..., tool_use_id: ...)
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
     *
     * @param BetaWebFetchToolResultErrorBlock|array{
     *   error_code: value-of<BetaWebFetchToolResultErrorCode>,
     *   type: 'web_fetch_tool_result_error',
     * }|BetaWebFetchBlock|array{
     *   content: BetaDocumentBlock,
     *   retrieved_at: string|null,
     *   type: 'web_fetch_result',
     *   url: string,
     * } $content
     */
    public static function with(
        BetaWebFetchToolResultErrorBlock|array|BetaWebFetchBlock $content,
        string $tool_use_id,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['tool_use_id'] = $tool_use_id;

        return $obj;
    }

    /**
     * @param BetaWebFetchToolResultErrorBlock|array{
     *   error_code: value-of<BetaWebFetchToolResultErrorCode>,
     *   type: 'web_fetch_tool_result_error',
     * }|BetaWebFetchBlock|array{
     *   content: BetaDocumentBlock,
     *   retrieved_at: string|null,
     *   type: 'web_fetch_result',
     *   url: string,
     * } $content
     */
    public function withContent(
        BetaWebFetchToolResultErrorBlock|array|BetaWebFetchBlock $content
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
