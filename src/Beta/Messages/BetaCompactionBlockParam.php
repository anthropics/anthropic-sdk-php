<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCompactionBlockParam\ToolChange;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A compaction block containing summary of previous context.
 *
 * Users should round-trip these blocks from responses to subsequent requests
 * to maintain context across compaction boundaries.
 *
 * When content is None, the block represents a failed compaction. The server
 * treats these as no-ops. Empty string content is not allowed.
 *
 * @phpstan-import-type ToolChangeVariants from \Anthropic\Beta\Messages\BetaCompactionBlockParam\ToolChange
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 * @phpstan-import-type ToolChangeShape from \Anthropic\Beta\Messages\BetaCompactionBlockParam\ToolChange
 *
 * @phpstan-type BetaCompactionBlockParamShape = array{
 *   type: 'compaction',
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 *   content?: string|null,
 *   encryptedContent?: string|null,
 *   signature?: string|null,
 *   toolChanges?: list<ToolChangeShape>|null,
 * }
 */
final class BetaCompactionBlockParam implements BaseModel
{
    /** @use SdkModel<BetaCompactionBlockParamShape> */
    use SdkModel;

    /** @var 'compaction' $type */
    #[Required(type: new ConstantOf('compaction'))]
    public string $type = 'compaction';

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * Summary of previously compacted content, or null if compaction failed.
     */
    #[Optional(nullable: true)]
    public ?string $content;

    /**
     * Opaque metadata from prior compaction, to be round-tripped verbatim.
     */
    #[Optional('encrypted_content', nullable: true)]
    public ?string $encryptedContent;

    /**
     * The block's signature as returned, to be sent back verbatim.
     */
    #[Optional(nullable: true)]
    public ?string $signature;

    /**
     * The tool changes of the compacted range, as the server returned them on this block: the `tool_addition` and `tool_removal` entries that take the request's `tools` to the tool set in effect at the end of the range. Send them back unchanged with the block.
     *
     * @var list<ToolChangeVariants>|null $toolChanges
     */
    #[Optional('tool_changes', list: ToolChange::class, nullable: true)]
    public ?array $toolChanges;

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
     * @param list<ToolChangeShape>|null $toolChanges
     */
    public static function with(
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        ?string $content = null,
        ?string $encryptedContent = null,
        ?string $signature = null,
        ?array $toolChanges = null,
    ): self {
        $self = new self;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $content && $self['content'] = $content;
        null !== $encryptedContent && $self['encryptedContent'] = $encryptedContent;
        null !== $signature && $self['signature'] = $signature;
        null !== $toolChanges && $self['toolChanges'] = $toolChanges;

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
     * Opaque metadata from prior compaction, to be round-tripped verbatim.
     */
    public function withEncryptedContent(?string $encryptedContent): self
    {
        $self = clone $this;
        $self['encryptedContent'] = $encryptedContent;

        return $self;
    }

    /**
     * The block's signature as returned, to be sent back verbatim.
     */
    public function withSignature(?string $signature): self
    {
        $self = clone $this;
        $self['signature'] = $signature;

        return $self;
    }

    /**
     * The tool changes of the compacted range, as the server returned them on this block: the `tool_addition` and `tool_removal` entries that take the request's `tools` to the tool set in effect at the end of the range. Send them back unchanged with the block.
     *
     * @param list<ToolChangeShape>|null $toolChanges
     */
    public function withToolChanges(?array $toolChanges): self
    {
        $self = clone $this;
        $self['toolChanges'] = $toolChanges;

        return $self;
    }
}
