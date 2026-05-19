<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Environments\EnvironmentUpdateParams\Config;
use Anthropic\Beta\Environments\EnvironmentUpdateParams\Scope;
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
 * @phpstan-import-type ConfigVariants from \Anthropic\Beta\Environments\EnvironmentUpdateParams\Config
 * @phpstan-import-type ConfigShape from \Anthropic\Beta\Environments\EnvironmentUpdateParams\Config
 *
 * @phpstan-type EnvironmentUpdateParamsShape = array{
 *   config?: ConfigShape|null,
 *   description?: string|null,
 *   metadata?: array<string,string|null>|null,
 *   name?: string|null,
 *   scope?: null|Scope|value-of<Scope>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class EnvironmentUpdateParams implements BaseModel
{
    /** @use SdkModel<EnvironmentUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Updated environment configuration.
     *
     * @var ConfigVariants|null $config
     */
    #[Optional(union: Config::class, nullable: true)]
    public BetaCloudConfigParams|BetaSelfHostedConfigParams|null $config;

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
     * The visibility scope for this environment. 'organization' makes the environment visible to all accounts. 'account' restricts visibility to the owning account only.
     *
     * @var value-of<Scope>|null $scope
     */
    #[Optional(enum: Scope::class, nullable: true)]
    public ?string $scope;

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
     * @param ConfigShape|null $config
     * @param array<string,string|null>|null $metadata
     * @param Scope|value-of<Scope>|null $scope
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        BetaCloudConfigParams|array|BetaSelfHostedConfigParams|null $config = null,
        ?string $description = null,
        ?array $metadata = null,
        ?string $name = null,
        Scope|string|null $scope = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $config && $self['config'] = $config;
        null !== $description && $self['description'] = $description;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $name && $self['name'] = $name;
        null !== $scope && $self['scope'] = $scope;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Updated environment configuration.
     *
     * @param ConfigShape|null $config
     */
    public function withConfig(
        BetaCloudConfigParams|array|BetaSelfHostedConfigParams|null $config
    ): self {
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
     * The visibility scope for this environment. 'organization' makes the environment visible to all accounts. 'account' restricts visibility to the owning account only.
     *
     * @param Scope|value-of<Scope>|null $scope
     */
    public function withScope(Scope|string|null $scope): self
    {
        $self = clone $this;
        $self['scope'] = $scope;

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
