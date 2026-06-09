<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Deployments\BetaManagedAgentsFileResourceConfig\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A file mounted into each session's container.
 *
 * @phpstan-type BetaManagedAgentsFileResourceConfigShape = array{
 *   fileID: string, type: Type|value-of<Type>, mountPath?: string|null
 * }
 */
final class BetaManagedAgentsFileResourceConfig implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsFileResourceConfigShape> */
    use SdkModel;

    /**
     * ID of a previously uploaded file.
     */
    #[Required('file_id')]
    public string $fileID;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Mount path in the container. Defaults to `/mnt/session/uploads/<file_id>`.
     */
    #[Optional('mount_path', nullable: true)]
    public ?string $mountPath;

    /**
     * `new BetaManagedAgentsFileResourceConfig()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsFileResourceConfig::with(fileID: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsFileResourceConfig)->withFileID(...)->withType(...)
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
        string $fileID,
        Type|string $type,
        ?string $mountPath = null
    ): self {
        $self = new self;

        $self['fileID'] = $fileID;
        $self['type'] = $type;

        null !== $mountPath && $self['mountPath'] = $mountPath;

        return $self;
    }

    /**
     * ID of a previously uploaded file.
     */
    public function withFileID(string $fileID): self
    {
        $self = clone $this;
        $self['fileID'] = $fileID;

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
     * Mount path in the container. Defaults to `/mnt/session/uploads/<file_id>`.
     */
    public function withMountPath(?string $mountPath): self
    {
        $self = clone $this;
        $self['mountPath'] = $mountPath;

        return $self;
    }
}
