<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebSearchToolResultBlockShape = array{
 *   content: BetaWebSearchToolResultError|list<BetaWebSearchResultBlock>,
 *   tool_use_id: string,
 *   type: 'web_search_tool_result',
 * }
 */
final class BetaWebSearchToolResultBlock implements BaseModel
{
    /** @use SdkModel<BetaWebSearchToolResultBlockShape> */
    use SdkModel;

    /** @var 'web_search_tool_result' $type */
    #[Required]
    public string $type = 'web_search_tool_result';

    /** @var BetaWebSearchToolResultError|list<BetaWebSearchResultBlock> $content */
    #[Required(union: BetaWebSearchToolResultBlockContent::class)]
    public BetaWebSearchToolResultError|array $content;

    #[Required]
    public string $tool_use_id;

    /**
     * `new BetaWebSearchToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebSearchToolResultBlock::with(content: ..., tool_use_id: ...)
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaWebSearchToolResultError|array{
     *   error_code: value-of<BetaWebSearchToolResultErrorCode>,
     *   type: 'web_search_tool_result_error',
     * }|list<BetaWebSearchResultBlock|array{
     *   encrypted_content: string,
     *   page_age: string|null,
     *   title: string,
     *   type: 'web_search_result',
     *   url: string,
     * }> $content
     */
    public static function with(
        BetaWebSearchToolResultError|array $content,
        string $tool_use_id
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['tool_use_id'] = $tool_use_id;

        return $obj;
    }

    /**
     * @param BetaWebSearchToolResultError|array{
     *   error_code: value-of<BetaWebSearchToolResultErrorCode>,
     *   type: 'web_search_tool_result_error',
     * }|list<BetaWebSearchResultBlock|array{
     *   encrypted_content: string,
     *   page_age: string|null,
     *   title: string,
     *   type: 'web_search_result',
     *   url: string,
     * }> $content
     */
    public function withContent(
        BetaWebSearchToolResultError|array $content
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
