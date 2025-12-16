<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaToolSearchToolResultBlockParam\Content
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 *
 * @phpstan-type BetaToolSearchToolResultBlockParamShape = array{
 *   content: BetaToolSearchToolResultErrorParam|BetaToolSearchToolSearchResultBlockParam|ContentShape,
 *   toolUseID: string,
 *   type: 'tool_search_tool_result',
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 * }
 */
final class BetaToolSearchToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaToolSearchToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'tool_search_tool_result' $type */
    #[Required]
    public string $type = 'tool_search_tool_result';

    #[Required]
    public BetaToolSearchToolResultErrorParam|BetaToolSearchToolSearchResultBlockParam $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * `new BetaToolSearchToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolSearchToolResultBlockParam::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolSearchToolResultBlockParam)->withContent(...)->withToolUseID(...)
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
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     */
    public static function with(
        BetaToolSearchToolResultErrorParam|array|BetaToolSearchToolSearchResultBlockParam $content,
        string $toolUseID,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
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
        BetaToolSearchToolResultErrorParam|array|BetaToolSearchToolSearchResultBlockParam $content,
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
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }
}
