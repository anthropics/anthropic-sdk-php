<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Unified Environment resource for both cloud and BYOC environments.
 *
 * @phpstan-import-type BetaCloudConfigShape from \Anthropic\Beta\Environments\BetaCloudConfig
 *
 * @phpstan-type BetaEnvironmentShape = array{
 *   id: string,
 *   archivedAt: string|null,
 *   config: BetaCloudConfig|BetaCloudConfigShape,
 *   createdAt: string,
 *   description: string,
 *   metadata: array<string,string>,
 *   name: string,
 *   type: 'environment',
 *   updatedAt: string,
 * }
 */
final class BetaEnvironment implements BaseModel
{
    /** @use SdkModel<BetaEnvironmentShape> */
    use SdkModel;

    /**
     * The type of object (always 'environment').
     *
     * @var 'environment' $type
     */
    #[Required]
    public string $type = 'environment';

    /**
     * Environment identifier (e.g., 'env_...').
     */
    #[Required]
    public string $id;

    /**
     * RFC 3339 timestamp when environment was archived, or null if not archived.
     */
    #[Required('archived_at')]
    public ?string $archivedAt;

    /**
     * `cloud` environment configuration.
     */
    #[Required]
    public BetaCloudConfig $config;

    /**
     * RFC 3339 timestamp when environment was created.
     */
    #[Required('created_at')]
    public string $createdAt;

    /**
     * User-provided description for the environment.
     */
    #[Required]
    public string $description;

    /**
     * User-provided metadata key-value pairs.
     *
     * @var array<string,string> $metadata
     */
    #[Required(map: 'string')]
    public array $metadata;

    /**
     * Human-readable name for the environment.
     */
    #[Required]
    public string $name;

    /**
     * RFC 3339 timestamp when environment was last updated.
     */
    #[Required('updated_at')]
    public string $updatedAt;

    /**
     * `new BetaEnvironment()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaEnvironment::with(
     *   id: ...,
     *   archivedAt: ...,
     *   config: ...,
     *   createdAt: ...,
     *   description: ...,
     *   metadata: ...,
     *   name: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaEnvironment)
     *   ->withID(...)
     *   ->withArchivedAt(...)
     *   ->withConfig(...)
     *   ->withCreatedAt(...)
     *   ->withDescription(...)
     *   ->withMetadata(...)
     *   ->withName(...)
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
     * @param BetaCloudConfig|BetaCloudConfigShape $config
     * @param array<string,string> $metadata
     */
    public static function with(
        string $id,
        ?string $archivedAt,
        BetaCloudConfig|array $config,
        string $createdAt,
        string $description,
        array $metadata,
        string $name,
        string $updatedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['archivedAt'] = $archivedAt;
        $self['config'] = $config;
        $self['createdAt'] = $createdAt;
        $self['description'] = $description;
        $self['metadata'] = $metadata;
        $self['name'] = $name;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Environment identifier (e.g., 'env_...').
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * RFC 3339 timestamp when environment was archived, or null if not archived.
     */
    public function withArchivedAt(?string $archivedAt): self
    {
        $self = clone $this;
        $self['archivedAt'] = $archivedAt;

        return $self;
    }

    /**
     * `cloud` environment configuration.
     *
     * @param BetaCloudConfig|BetaCloudConfigShape $config
     */
    public function withConfig(BetaCloudConfig|array $config): self
    {
        $self = clone $this;
        $self['config'] = $config;

        return $self;
    }

    /**
     * RFC 3339 timestamp when environment was created.
     */
    public function withCreatedAt(string $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * User-provided description for the environment.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * User-provided metadata key-value pairs.
     *
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Human-readable name for the environment.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * The type of object (always 'environment').
     *
     * @param 'environment' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * RFC 3339 timestamp when environment was last updated.
     */
    public function withUpdatedAt(string $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
