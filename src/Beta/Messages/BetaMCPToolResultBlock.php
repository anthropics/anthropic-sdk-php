<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaMCPToolResultBlock\Content;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMCPToolResultBlockShape = array{
 *   content: string|list<BetaTextBlock>,
 *   is_error: bool,
 *   tool_use_id: string,
 *   type: 'mcp_tool_result',
 * }
 */
final class BetaMCPToolResultBlock implements BaseModel
{
    /** @use SdkModel<BetaMCPToolResultBlockShape> */
    use SdkModel;

    /** @var 'mcp_tool_result' $type */
    #[Api]
    public string $type = 'mcp_tool_result';

    /** @var string|list<BetaTextBlock> $content */
    #[Api(union: Content::class)]
    public string|array $content;

    #[Api]
    public bool $is_error;

    #[Api]
    public string $tool_use_id;

    /**
     * `new BetaMCPToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMCPToolResultBlock::with(content: ..., is_error: ..., tool_use_id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMCPToolResultBlock)
     *   ->withContent(...)
     *   ->withIsError(...)
     *   ->withToolUseID(...)
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
     * @param string|list<BetaTextBlock|array{
     *   citations: list<BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation>|null,
     *   text: string,
     *   type: 'text',
     * }> $content
     */
    public static function with(
        string|array $content,
        string $tool_use_id,
        bool $is_error = false
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['is_error'] = $is_error;
        $obj['tool_use_id'] = $tool_use_id;

        return $obj;
    }

    /**
     * @param string|list<BetaTextBlock|array{
     *   citations: list<BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation>|null,
     *   text: string,
     *   type: 'text',
     * }> $content
     */
    public function withContent(string|array $content): self
    {
        $obj = clone $this;
        $obj['content'] = $content;

        return $obj;
    }

    public function withIsError(bool $isError): self
    {
        $obj = clone $this;
        $obj['is_error'] = $isError;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj['tool_use_id'] = $toolUseID;

        return $obj;
    }
}
