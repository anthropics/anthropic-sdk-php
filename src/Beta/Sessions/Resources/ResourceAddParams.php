<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Resources;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Sessions\Resources\ResourceAddParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Add Session Resource.
 *
 * @see Anthropic\Services\Beta\Sessions\ResourcesService::add()
 *
 * @phpstan-type ResourceAddParamsShape = array{
 *   fileID: string,
 *   type: Type|value-of<Type>,
 *   mountPath?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class ResourceAddParams implements BaseModel
{
    /** @use SdkModel<ResourceAddParamsShape> */
    use SdkModel;
    use SdkParams;

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
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new ResourceAddParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ResourceAddParams::with(fileID: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ResourceAddParams)->withFileID(...)->withType(...)
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $fileID,
        Type|string $type,
        ?string $mountPath = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['fileID'] = $fileID;
        $self['type'] = $type;

        null !== $mountPath && $self['mountPath'] = $mountPath;
        null !== $betas && $self['betas'] = $betas;

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

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
