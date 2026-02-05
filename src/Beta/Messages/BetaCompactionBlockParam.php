<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A compaction block containing summary of previous context.
 *
 * Users should round-trip these blocks from responses to subsequent requests
 * to maintain context across compaction boundaries.
 *
 * When content is None, the block represents a failed compaction. The server
 * treats these as no-ops. Empty string content is not allowed.
 *
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 *
 * @phpstan-type BetaCompactionBlockParamShape = array{
 *   content: string|null,
 *   type: 'compaction',
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 * }
 */
final class BetaCompactionBlockParam implements BaseModel
{
    /** @use SdkModel<BetaCompactionBlockParamShape> */
    use SdkModel;

    /** @var 'compaction' $type */
    #[Required]
    public string $type = 'compaction';

    /**
     * Summary of previously compacted content, or null if compaction failed.
     */
    #[Required]
    public ?string $content;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * `new BetaCompactionBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCompactionBlockParam::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCompactionBlockParam)->withContent(...)
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
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     */
    public static function with(
        ?string $content,
        BetaCacheControlEphemeral|array|null $cacheControl = null
    ): self {
        $self = new self;

        $self['content'] = $content;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * Summary of previously compacted content, or null if compaction failed.
     */
    public function withContent(?string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * @param 'compaction' $type
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
