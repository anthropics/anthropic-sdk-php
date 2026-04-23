<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A compaction block returned when autocompact is triggered.
 *
 * When content is None, it indicates the compaction failed to produce a valid
 * summary (e.g., malformed output from the model). Clients may round-trip
 * compaction blocks with null content; the server treats them as no-ops.
 *
 * @phpstan-type BetaCompactionBlockShape = array{
 *   content: string|null, encryptedContent: string|null, type: 'compaction'
 * }
 */
final class BetaCompactionBlock implements BaseModel
{
    /** @use SdkModel<BetaCompactionBlockShape> */
    use SdkModel;

    /** @var 'compaction' $type */
    #[Required]
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
        ?string $encryptedContent
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['encryptedContent'] = $encryptedContent;

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
}
