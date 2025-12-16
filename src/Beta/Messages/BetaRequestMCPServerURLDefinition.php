<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaRequestMCPServerToolConfigurationShape from \Anthropic\Beta\Messages\BetaRequestMCPServerToolConfiguration
 *
 * @phpstan-type BetaRequestMCPServerURLDefinitionShape = array{
 *   name: string,
 *   type: 'url',
 *   url: string,
 *   authorizationToken?: string|null,
 *   toolConfiguration?: null|BetaRequestMCPServerToolConfiguration|BetaRequestMCPServerToolConfigurationShape,
 * }
 */
final class BetaRequestMCPServerURLDefinition implements BaseModel
{
    /** @use SdkModel<BetaRequestMCPServerURLDefinitionShape> */
    use SdkModel;

    /** @var 'url' $type */
    #[Required]
    public string $type = 'url';

    #[Required]
    public string $name;

    #[Required]
    public string $url;

    #[Optional('authorization_token', nullable: true)]
    public ?string $authorizationToken;

    #[Optional('tool_configuration', nullable: true)]
    public ?BetaRequestMCPServerToolConfiguration $toolConfiguration;

    /**
     * `new BetaRequestMCPServerURLDefinition()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRequestMCPServerURLDefinition::with(name: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRequestMCPServerURLDefinition)->withName(...)->withURL(...)
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
     * @param BetaRequestMCPServerToolConfigurationShape|null $toolConfiguration
     */
    public static function with(
        string $name,
        string $url,
        ?string $authorizationToken = null,
        BetaRequestMCPServerToolConfiguration|array|null $toolConfiguration = null,
    ): self {
        $self = new self;

        $self['name'] = $name;
        $self['url'] = $url;

        null !== $authorizationToken && $self['authorizationToken'] = $authorizationToken;
        null !== $toolConfiguration && $self['toolConfiguration'] = $toolConfiguration;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    public function withAuthorizationToken(?string $authorizationToken): self
    {
        $self = clone $this;
        $self['authorizationToken'] = $authorizationToken;

        return $self;
    }

    /**
     * @param BetaRequestMCPServerToolConfigurationShape|null $toolConfiguration
     */
    public function withToolConfiguration(
        BetaRequestMCPServerToolConfiguration|array|null $toolConfiguration
    ): self {
        $self = clone $this;
        $self['toolConfiguration'] = $toolConfiguration;

        return $self;
    }
}
