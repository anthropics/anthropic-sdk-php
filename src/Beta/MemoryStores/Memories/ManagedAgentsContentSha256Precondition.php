<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsContentSha256Precondition\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A precondition that applies an update only if the memory's current content has the hash in `content_sha256`.
 *
 * If the hashes differ, the request fails with HTTP status 409. Retrieve the memory and retry. If the memory already has exactly the requested `content` and `path`, the request succeeds even though the hashes differ.
 *
 * @phpstan-type ManagedAgentsContentSha256PreconditionShape = array{
 *   type: Type|value-of<Type>, contentSha256?: string|null
 * }
 */
final class ManagedAgentsContentSha256Precondition implements BaseModel
{
    /** @use SdkModel<ManagedAgentsContentSha256PreconditionShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Expected `content_sha256` of the stored memory (64 lowercase hexadecimal characters). Typically the `content_sha256` returned by a prior read or list call. Because the server applies no content normalization, clients can also compute this locally as the SHA-256 of the UTF-8 content bytes.
     */
    #[Optional('content_sha256')]
    public ?string $contentSha256;

    /**
     * `new ManagedAgentsContentSha256Precondition()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsContentSha256Precondition::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsContentSha256Precondition())->withType(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(
        Type|string $type,
        ?string $contentSha256 = null
    ): self {
        $self = new self;

        $self['type'] = $type;

        null !== $contentSha256 && $self['contentSha256'] = $contentSha256;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
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
