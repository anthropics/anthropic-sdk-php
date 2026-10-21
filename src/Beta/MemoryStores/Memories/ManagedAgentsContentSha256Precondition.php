<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A precondition that applies an update only if the memory's current content has the hash in `content_sha256`.
 *
 * If the hashes differ, the request fails with HTTP status 409. Retrieve the memory and retry. If the memory already has exactly the requested `content` and `path`, the request succeeds even though the hashes differ.
 *
 * @phpstan-type ManagedAgentsContentSha256PreconditionShape = array{
 *   type: 'content_sha256', contentSha256?: string|null
 * }
 */
final class ManagedAgentsContentSha256Precondition implements BaseModel
{
    /** @use SdkModel<ManagedAgentsContentSha256PreconditionShape> */
    use SdkModel;

    /** @var 'content_sha256' $type */
    #[Required(type: new ConstantOf('content_sha256'))]
    public string $type = 'content_sha256';

    /**
     * Expected `content_sha256` of the stored memory (64 lowercase hexadecimal characters). Typically the `content_sha256` returned by a prior read or list call. Because the server applies no content normalization, clients can also compute this locally as the SHA-256 of the UTF-8 content bytes.
     */
    #[Optional('content_sha256')]
    public ?string $contentSha256;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $contentSha256 = null): self
    {
        $self = new self;

        null !== $contentSha256 && $self['contentSha256'] = $contentSha256;

        return $self;
    }

    /**
     * @param 'content_sha256' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Expected `content_sha256` of the stored memory (64 lowercase hexadecimal characters). Typically the `content_sha256` returned by a prior read or list call. Because the server applies no content normalization, clients can also compute this locally as the SHA-256 of the UTF-8 content bytes.
     */
    public function withContentSha256(string $contentSha256): self
    {
        $self = clone $this;
        $self['contentSha256'] = $contentSha256;

        return $self;
    }
}
