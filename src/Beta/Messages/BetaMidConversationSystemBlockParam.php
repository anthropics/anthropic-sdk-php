<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * System instructions that appear mid-conversation.
 *
 * Use this block to provide or update system-level instructions at a specific
 * point in the conversation, rather than only via the top-level `system` parameter.
 *
 * @phpstan-import-type BetaTextBlockParamShape from \Anthropic\Beta\Messages\BetaTextBlockParam
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 *
 * @phpstan-type BetaMidConversationSystemBlockParamShape = array{
 *   content: list<BetaTextBlockParam|BetaTextBlockParamShape>,
 *   type: 'mid_conv_system',
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 * }
 */
final class BetaMidConversationSystemBlockParam implements BaseModel
{
    /** @use SdkModel<BetaMidConversationSystemBlockParamShape> */
    use SdkModel;

    /** @var 'mid_conv_system' $type */
    #[Required]
    public string $type = 'mid_conv_system';

    /**
     * System instruction text blocks.
     *
     * @var list<BetaTextBlockParam> $content
     */
    #[Required(list: BetaTextBlockParam::class)]
    public array $content;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * `new BetaMidConversationSystemBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMidConversationSystemBlockParam::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMidConversationSystemBlockParam)->withContent(...)
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
     * @param list<BetaTextBlockParam|BetaTextBlockParamShape> $content
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     */
    public static function with(
        array $content,
        BetaCacheControlEphemeral|array|null $cacheControl = null
    ): self {
        $self = new self;

        $self['content'] = $content;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * System instruction text blocks.
     *
     * @param list<BetaTextBlockParam|BetaTextBlockParamShape> $content
     */
    public function withContent(array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * @param 'mid_conv_system' $type
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
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }
}
