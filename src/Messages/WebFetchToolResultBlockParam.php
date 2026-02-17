<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\WebFetchToolResultBlockParam\Caller;
use Anthropic\Messages\WebFetchToolResultBlockParam\Caller\ServerToolCaller20260120;

/**
 * @phpstan-import-type ContentVariants from \Anthropic\Messages\WebFetchToolResultBlockParam\Content
 * @phpstan-import-type CallerVariants from \Anthropic\Messages\WebFetchToolResultBlockParam\Caller
 * @phpstan-import-type ContentShape from \Anthropic\Messages\WebFetchToolResultBlockParam\Content
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 * @phpstan-import-type CallerShape from \Anthropic\Messages\WebFetchToolResultBlockParam\Caller
 *
 * @phpstan-type WebFetchToolResultBlockParamShape = array{
 *   content: ContentShape,
 *   toolUseID: string,
 *   type: 'web_fetch_tool_result',
 *   cacheControl?: null|CacheControlEphemeral|CacheControlEphemeralShape,
 *   caller?: CallerShape|null,
 * }
 */
final class WebFetchToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<WebFetchToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'web_fetch_tool_result' $type */
    #[Required]
    public string $type = 'web_fetch_tool_result';

    /** @var ContentVariants $content */
    #[Required]
    public WebFetchToolResultErrorBlockParam|WebFetchBlockParam $content;

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
     * `new WebFetchToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebFetchToolResultBlockParam::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebFetchToolResultBlockParam)->withContent(...)->withToolUseID(...)
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
     * @param CallerShape|null $caller
     */
    public static function with(
        WebFetchToolResultErrorBlockParam|array|WebFetchBlockParam $content,
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
     * @param ContentShape $content
     */
    public function withContent(
        WebFetchToolResultErrorBlockParam|array|WebFetchBlockParam $content
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
     * @param 'web_fetch_tool_result' $type
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
