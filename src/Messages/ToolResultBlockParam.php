<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\ToolResultBlockParam\Content;

/**
 * @phpstan-type ToolResultBlockParamShape = array{
 *   tool_use_id: string,
 *   type: "tool_result",
 *   cache_control?: CacheControlEphemeral|null,
 *   content?: string|null|list<TextBlockParam|ImageBlockParam|SearchResultBlockParam|DocumentBlockParam>,
 *   is_error?: bool|null,
 * }
 */
final class ToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<ToolResultBlockParamShape> */
    use SdkModel;

    /** @var "tool_result" $type */
    #[Api]
    public string $type = 'tool_result';

    #[Api]
    public string $tool_use_id;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?CacheControlEphemeral $cache_control;

    /**
     * @var string|list<TextBlockParam|ImageBlockParam|SearchResultBlockParam|DocumentBlockParam>|null $content
     */
    #[Api(union: Content::class, optional: true)]
    public string|array|null $content;

    #[Api(optional: true)]
    public ?bool $is_error;

    /**
     * `new ToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolResultBlockParam::with(tool_use_id: ...)
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
        string $tool_use_id,
        ?CacheControlEphemeral $cache_control = null,
        string|array|null $content = null,
        ?bool $is_error = null,
    ): self {
        $obj = new self;

        $obj->tool_use_id = $tool_use_id;

        null !== $cache_control && $obj->cache_control = $cache_control;
        null !== $content && $obj->content = $content;
        null !== $is_error && $obj->is_error = $is_error;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj->tool_use_id = $toolUseID;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(?CacheControlEphemeral $cacheControl): self
    {
        $obj = clone $this;
        $obj->cache_control = $cacheControl;

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
        $obj->is_error = $isError;

        return $obj;
    }
}
