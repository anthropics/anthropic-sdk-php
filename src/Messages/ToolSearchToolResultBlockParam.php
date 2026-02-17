<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ContentVariants from \Anthropic\Messages\ToolSearchToolResultBlockParam\Content
 * @phpstan-import-type ContentShape from \Anthropic\Messages\ToolSearchToolResultBlockParam\Content
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 *
 * @phpstan-type ToolSearchToolResultBlockParamShape = array{
 *   content: ContentShape,
 *   toolUseID: string,
 *   type: 'tool_search_tool_result',
 *   cacheControl?: null|CacheControlEphemeral|CacheControlEphemeralShape,
 * }
 */
final class ToolSearchToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<ToolSearchToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'tool_search_tool_result' $type */
    #[Required]
    public string $type = 'tool_search_tool_result';

    /** @var ContentVariants $content */
    #[Required]
    public ToolSearchToolResultErrorParam|ToolSearchToolSearchResultBlockParam $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * `new ToolSearchToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolSearchToolResultBlockParam::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolSearchToolResultBlockParam)->withContent(...)->withToolUseID(...)
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
     * @param ContentShape $content
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     */
    public static function with(
        ToolSearchToolResultErrorParam|array|ToolSearchToolSearchResultBlockParam $content,
        string $toolUseID,
        CacheControlEphemeral|array|null $cacheControl = null,
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['toolUseID'] = $toolUseID;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * @param ContentShape $content
     */
    public function withContent(
        ToolSearchToolResultErrorParam|array|ToolSearchToolSearchResultBlockParam $content,
    ): self {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $self = clone $this;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }

    /**
     * @param 'tool_search_tool_result' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }
}
