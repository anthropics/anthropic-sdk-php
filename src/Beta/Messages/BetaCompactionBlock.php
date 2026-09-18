<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A compaction block returned when autocompact is triggered.
 *
 * When content is None, it indicates the compaction failed to produce a valid
 * summary (e.g., malformed output from the model). Clients may round-trip
 * compaction blocks with null content; the server treats them as no-ops.
 *
 * @phpstan-type BetaCompactionBlockShape = array{
 *   content: string|null,
 *   encryptedContent: string|null,
 *   type: 'compaction',
 *   signature?: string|null,
 * }
 */
final class BetaCompactionBlock implements BaseModel
{
    /** @use SdkModel<BetaCompactionBlockShape> */
    use SdkModel;

    /** @var 'compaction' $type */
    #[Required(type: new ConstantOf('compaction'))]
    public string $type = 'compaction';

    /**
     * Summary of compacted content, or null if compaction failed.
     */
    #[Required]
    public ?string $content;

    /**
     * Opaque metadata from prior compaction, to be round-tripped verbatim.
     */
    #[Required('encrypted_content')]
    public ?string $encryptedContent;

    /**
     * Signature over the summary, to be sent back with the block verbatim.
     */
    #[Optional(nullable: true)]
    public ?string $signature;

    /**
     * `new BetaCompactionBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCompactionBlock::with(content: ..., encryptedContent: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCompactionBlock)->withContent(...)->withEncryptedContent(...)
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
     */
    public static function with(
        ?string $content,
        ?string $encryptedContent,
        ?string $signature = null
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['encryptedContent'] = $encryptedContent;

        null !== $signature && $self['signature'] = $signature;

        return $self;
    }

    /**
     * Summary of compacted content, or null if compaction failed.
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
     * @param 'compaction' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Signature over the summary, to be sent back with the block verbatim.
     */
    public function withSignature(?string $signature): self
    {
        $self = clone $this;
        $self['signature'] = $signature;

        return $self;
    }
}
