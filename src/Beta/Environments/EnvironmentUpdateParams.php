<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * Update an existing environment's configuration.
 *
 * @see Anthropic\Services\Beta\EnvironmentsService::update()
 *
 * @phpstan-import-type BetaCloudConfigParamsShape from \Anthropic\Beta\Environments\BetaCloudConfigParams
 *
 * @phpstan-type EnvironmentUpdateParamsShape = array{
 *   config?: null|BetaCloudConfigParams|BetaCloudConfigParamsShape,
 *   description?: string|null,
 *   metadata?: array<string,string|null>|null,
 *   name?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class EnvironmentUpdateParams implements BaseModel
{
    /** @use SdkModel<EnvironmentUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Request params for `cloud` environment configuration.
     *
     * Fields default to null; on update, omitted fields preserve the
     * existing value.
     */
    #[Optional(nullable: true)]
    public ?BetaCloudConfigParams $config;

    /**
     * Updated description of the environment.
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * User-provided metadata key-value pairs. Set a value to null or empty string to delete the key.
     *
     * @var array<string,string|null>|null $metadata
     */
    #[Optional(type: new MapOf('string', nullable: true))]
    public ?array $metadata;

    /**
     * Updated name for the environment.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaCloudConfigParams|BetaCloudConfigParamsShape|null $config
     * @param array<string,string|null>|null $metadata
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        BetaCloudConfigParams|array|null $config = null,
        ?string $description = null,
        ?array $metadata = null,
        ?string $name = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $config && $self['config'] = $config;
        null !== $description && $self['description'] = $description;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $name && $self['name'] = $name;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Request params for `cloud` environment configuration.
     *
     * Fields default to null; on update, omitted fields preserve the
     * existing value.
     *
     * @param BetaCloudConfigParams|BetaCloudConfigParamsShape|null $config
     */
    public function withConfig(BetaCloudConfigParams|array|null $config): self
    {
        $self = clone $this;
        $self['config'] = $config;

        return $self;
    }

    /**
     * Updated description of the environment.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * User-provided metadata key-value pairs. Set a value to null or empty string to delete the key.
     *
     * @param array<string,string|null> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Updated name for the environment.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

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
