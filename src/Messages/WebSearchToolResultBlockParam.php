<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\WebSearchToolResultBlockParam\Caller;

/**
 * @phpstan-import-type WebSearchToolResultBlockParamContentVariants from \Anthropic\Messages\WebSearchToolResultBlockParamContent
 * @phpstan-import-type CallerVariants from \Anthropic\Messages\WebSearchToolResultBlockParam\Caller
 * @phpstan-import-type WebSearchToolResultBlockParamContentShape from \Anthropic\Messages\WebSearchToolResultBlockParamContent
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 * @phpstan-import-type CallerShape from \Anthropic\Messages\WebSearchToolResultBlockParam\Caller
 *
 * @phpstan-type WebSearchToolResultBlockParamShape = array{
 *   content: WebSearchToolResultBlockParamContentShape,
 *   toolUseID: string,
 *   type: 'web_search_tool_result',
 *   cacheControl?: null|CacheControlEphemeral|CacheControlEphemeralShape,
 *   caller?: CallerShape|null,
 * }
 */
final class WebSearchToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<WebSearchToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'web_search_tool_result' $type */
    #[Required]
    public string $type = 'web_search_tool_result';

    /** @var WebSearchToolResultBlockParamContentVariants $content */
    #[Required(union: WebSearchToolResultBlockParamContent::class)]
    public array|WebSearchToolRequestError $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * Tool invocation directly from the model.
     *
     * @var CallerVariants|null $caller
     */
    #[Optional(union: Caller::class)]
    public DirectCaller|ServerToolCaller|ServerToolCaller20260120|null $caller;

    /**
     * `new WebSearchToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebSearchToolResultBlockParam::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebSearchToolResultBlockParam)->withContent(...)->withToolUseID(...)
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
     * @param WebSearchToolResultBlockParamContentShape $content
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     * @param CallerShape|null $caller
     */
    public static function with(
        array|WebSearchToolRequestError $content,
        string $toolUseID,
        CacheControlEphemeral|array|null $cacheControl = null,
        DirectCaller|array|ServerToolCaller|ServerToolCaller20260120|null $caller = null,
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['toolUseID'] = $toolUseID;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $caller && $self['caller'] = $caller;

        return $self;
    }

    /**
     * @param WebSearchToolResultBlockParamContentShape $content
     */
    public function withContent(array|WebSearchToolRequestError $content): self
    {
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
     * @param 'web_search_tool_result' $type
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

    /**
     * Tool invocation directly from the model.
     *
     * @param CallerShape $caller
     */
    public function withCaller(
        DirectCaller|array|ServerToolCaller|ServerToolCaller20260120 $caller
    ): self {
        $self = clone $this;
        $self['caller'] = $caller;

        return $self;
    }
}
