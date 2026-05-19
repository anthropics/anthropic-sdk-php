<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Environments\EnvironmentCreateParams\Config;
use Anthropic\Beta\Environments\EnvironmentCreateParams\Scope;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create a new environment with the specified configuration.
 *
 * @see Anthropic\Services\Beta\EnvironmentsService::create()
 *
 * @phpstan-import-type ConfigVariants from \Anthropic\Beta\Environments\EnvironmentCreateParams\Config
 * @phpstan-import-type ConfigShape from \Anthropic\Beta\Environments\EnvironmentCreateParams\Config
 *
 * @phpstan-type EnvironmentCreateParamsShape = array{
 *   name: string,
 *   config?: ConfigShape|null,
 *   description?: string|null,
 *   metadata?: array<string,string>|null,
 *   scope?: null|Scope|value-of<Scope>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class EnvironmentCreateParams implements BaseModel
{
    /** @use SdkModel<EnvironmentCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Human-readable name for the environment.
     */
    #[Required]
    public string $name;

    /**
     * Environment configuration.
     *
     * @var ConfigVariants|null $config
     */
    #[Optional(union: Config::class, nullable: true)]
    public BetaCloudConfigParams|BetaSelfHostedConfigParams|null $config;

    /**
     * Optional description of the environment.
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * User-provided metadata key-value pairs.
     *
     * @var array<string,string>|null $metadata
     */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * The visibility scope for this environment. 'organization' makes the environment visible to all accounts. 'account' restricts visibility to the owning account only. Only applicable for self-hosted environments. If not specified, defaults based on organization type.
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

    /**
     * `new EnvironmentCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * EnvironmentCreateParams::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new EnvironmentCreateParams)->withName(...)
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
     * @param ConfigShape|null $config
     * @param array<string,string>|null $metadata
     * @param Scope|value-of<Scope>|null $scope
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $name,
        BetaCloudConfigParams|array|BetaSelfHostedConfigParams|null $config = null,
        ?string $description = null,
        ?array $metadata = null,
        Scope|string|null $scope = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $config && $self['config'] = $config;
        null !== $description && $self['description'] = $description;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $scope && $self['scope'] = $scope;
        null !== $betas && $self['betas'] = $betas;

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
     * Environment configuration.
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
     * Optional description of the environment.
     */
    public function withDescription(?string $description): self
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
     * The visibility scope for this environment. 'organization' makes the environment visible to all accounts. 'account' restricts visibility to the owning account only. Only applicable for self-hosted environments. If not specified, defaults based on organization type.
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
