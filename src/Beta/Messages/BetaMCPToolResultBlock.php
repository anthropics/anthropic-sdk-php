<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaMCPToolResultBlock\Content;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_mcp_tool_result_block_alias = array{
 *   content: string|list<BetaTextBlock>,
 *   isError: bool,
 *   toolUseID: string,
 *   type: string,
 * }
 */
final class BetaMCPToolResultBlock implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'mcp_tool_result';

    /** @var string|list<BetaTextBlock> $content */
    #[Api(union: Content::class)]
    public string|array $content;

    #[Api('is_error')]
    public bool $isError;

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * `new BetaMCPToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMCPToolResultBlock::with(content: ..., isError: ..., toolUseID: ...)
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param string|list<BetaTextBlock> $content
     */
    public static function with(
        string|array $content,
        string $toolUseID,
        bool $isError = false
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->isError = $isError;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }

    /**
     * @param string|list<BetaTextBlock> $content
     */
    public function withContent(string|array $content): self
    {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    public function withIsError(bool $isError): self
    {
        $obj = clone $this;
        $obj->isError = $isError;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }
}
