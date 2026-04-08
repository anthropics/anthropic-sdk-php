<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Resources;

use Anthropic\Beta\Sessions\Resources\ManagedAgentsFileResource\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ManagedAgentsFileResourceShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   fileID: string,
 *   mountPath: string,
 *   type: Type|value-of<Type>,
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class ManagedAgentsFileResource implements BaseModel
{
    /** @use SdkModel<ManagedAgentsFileResourceShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    #[Required('file_id')]
    public string $fileID;

    #[Required('mount_path')]
    public string $mountPath;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * `new ManagedAgentsFileResource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsFileResource::with(
     *   id: ...,
     *   createdAt: ...,
     *   fileID: ...,
     *   mountPath: ...,
     *   type: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsFileResource)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withFileID(...)
     *   ->withMountPath(...)
     *   ->withType(...)
     *   ->withUpdatedAt(...)
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
        string $id,
        \DateTimeInterface $createdAt,
        string $fileID,
        string $mountPath,
        Type|string $type,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['fileID'] = $fileID;
        $self['mountPath'] = $mountPath;
        $self['type'] = $type;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withFileID(string $fileID): self
    {
        $self = clone $this;
        $self['fileID'] = $fileID;

        return $self;
    }

    public function withMountPath(string $mountPath): self
    {
        $self = clone $this;
        $self['mountPath'] = $mountPath;

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
     * A timestamp in RFC 3339 format.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
