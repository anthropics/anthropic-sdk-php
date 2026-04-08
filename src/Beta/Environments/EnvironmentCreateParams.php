<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Beta\AnthropicBeta;
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
 * @phpstan-import-type BetaCloudConfigParamsShape from \Anthropic\Beta\Environments\BetaCloudConfigParams
 *
 * @phpstan-type EnvironmentCreateParamsShape = array{
 *   name: string,
 *   config?: null|BetaCloudConfigParams|BetaCloudConfigParamsShape,
 *   description?: string|null,
 *   metadata?: array<string,string>|null,
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
     * Request params for `cloud` environment configuration.
     *
     * Fields default to null; on update, omitted fields preserve the
     * existing value.
     */
    #[Optional(nullable: true)]
    public ?BetaCloudConfigParams $config;

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
     * @param BetaCloudConfigParams|BetaCloudConfigParamsShape|null $config
     * @param array<string,string>|null $metadata
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $name,
        BetaCloudConfigParams|array|null $config = null,
        ?string $description = null,
        ?array $metadata = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $config && $self['config'] = $config;
        null !== $description && $self['description'] = $description;
        null !== $metadata && $self['metadata'] = $metadata;
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
