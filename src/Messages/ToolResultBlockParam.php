<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\ToolResultBlockParam\Content;

/**
 * @phpstan-type tool_result_block_param = array{
 *   toolUseID: string,
 *   type: string,
 *   cacheControl?: CacheControlEphemeral|null,
 *   content?: string|null|list<TextBlockParam|ImageBlockParam|SearchResultBlockParam|DocumentBlockParam>,
 *   isError?: bool|null,
 * }
 */
final class ToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<tool_result_block_param> */
    use SdkModel;

    #[Api]
    public string $type = 'tool_result';

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', nullable: true, optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * @var string|list<TextBlockParam|ImageBlockParam|SearchResultBlockParam|DocumentBlockParam>|null $content
     */
    #[Api(union: Content::class, optional: true)]
    public string|array|null $content;

    #[Api('is_error', optional: true)]
    public ?bool $isError;

    /**
     * `new ToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolResultBlockParam::with(toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolResultBlockParam)->withToolUseID(...)
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
     * @param string|list<TextBlockParam|ImageBlockParam|SearchResultBlockParam|DocumentBlockParam> $content
     */
    public static function with(
        string $toolUseID,
        ?CacheControlEphemeral $cacheControl = null,
        string|array|null $content = null,
        ?bool $isError = null,
    ): self {
        $obj = new self;

        $obj->toolUseID = $toolUseID;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;
        null !== $content && $obj->content = $content;
        null !== $isError && $obj->isError = $isError;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(?CacheControlEphemeral $cacheControl): self
    {
        $obj = clone $this;
        $obj->cacheControl = $cacheControl;

        return $obj;
    }

    /**
     * @param string|list<TextBlockParam|ImageBlockParam|SearchResultBlockParam|DocumentBlockParam> $content
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
}
