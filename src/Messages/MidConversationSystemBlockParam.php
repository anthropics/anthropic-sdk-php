<?php

declare(strict_types=1);

namespace Anthropic\Messages;

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
 * @phpstan-import-type TextBlockParamShape from \Anthropic\Messages\TextBlockParam
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 *
 * @phpstan-type MidConversationSystemBlockParamShape = array{
 *   content: list<TextBlockParam|TextBlockParamShape>,
 *   type: 'mid_conv_system',
 *   cacheControl?: null|CacheControlEphemeral|CacheControlEphemeralShape,
 * }
 */
final class MidConversationSystemBlockParam implements BaseModel
{
    /** @use SdkModel<MidConversationSystemBlockParamShape> */
    use SdkModel;

    /** @var 'mid_conv_system' $type */
    #[Required]
    public string $type = 'mid_conv_system';

    /**
     * System instruction text blocks.
     *
     * @var list<TextBlockParam> $content
     */
    #[Required(list: TextBlockParam::class)]
    public array $content;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * `new MidConversationSystemBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MidConversationSystemBlockParam::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MidConversationSystemBlockParam)->withContent(...)
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
     * @param list<TextBlockParam|TextBlockParamShape> $content
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     */
    public static function with(
        array $content,
        CacheControlEphemeral|array|null $cacheControl = null
    ): self {
        $self = new self;

        $self['content'] = $content;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * System instruction text blocks.
     *
     * @param list<TextBlockParam|TextBlockParamShape> $content
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
