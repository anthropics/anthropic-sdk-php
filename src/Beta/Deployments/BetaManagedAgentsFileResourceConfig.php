<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A file mounted into each session's container.
 *
 * @phpstan-type BetaManagedAgentsFileResourceConfigShape = array{
 *   fileID: string, type: 'file', mountPath?: string|null
 * }
 */
final class BetaManagedAgentsFileResourceConfig implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsFileResourceConfigShape> */
    use SdkModel;

    /** @var 'file' $type */
    #[Required(type: new ConstantOf('file'))]
    public string $type = 'file';

    /**
     * ID of a previously uploaded file.
     */
    #[Required('file_id')]
    public string $fileID;

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
     * BetaManagedAgentsFileResourceConfig::with(fileID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsFileResourceConfig())->withFileID(...)
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
    public static function with(string $fileID, ?string $mountPath = null): self
    {
        $self = new self;

        $self['fileID'] = $fileID;

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
     * @param 'file' $type
     */
    public function withType(string $type): self
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
