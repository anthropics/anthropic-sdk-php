<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRequestMCPServerURLDefinitionShape = array{
 *   name: string,
 *   type?: 'url',
 *   url: string,
 *   authorizationToken?: string|null,
 *   toolConfiguration?: BetaRequestMCPServerToolConfiguration|null,
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
     * @param BetaRequestMCPServerToolConfiguration|array{
     *   allowedTools?: list<string>|null, enabled?: bool|null
     * }|null $toolConfiguration
     */
    public static function with(
        string $name,
        string $url,
        ?string $authorizationToken = null,
        BetaRequestMCPServerToolConfiguration|array|null $toolConfiguration = null,
    ): self {
        $obj = new self;

        $obj['name'] = $name;
        $obj['url'] = $url;

        null !== $authorizationToken && $obj['authorizationToken'] = $authorizationToken;
        null !== $toolConfiguration && $obj['toolConfiguration'] = $toolConfiguration;

        return $obj;
    }

    public function withName(string $name): self
    {
        $obj = clone $this;
        $obj['name'] = $name;

        return $obj;
    }

    public function withURL(string $url): self
    {
        $obj = clone $this;
        $obj['url'] = $url;

        return $obj;
    }

    public function withAuthorizationToken(?string $authorizationToken): self
    {
        $obj = clone $this;
        $obj['authorizationToken'] = $authorizationToken;

        return $obj;
    }

    /**
     * @param BetaRequestMCPServerToolConfiguration|array{
     *   allowedTools?: list<string>|null, enabled?: bool|null
     * }|null $toolConfiguration
     */
    public function withToolConfiguration(
        BetaRequestMCPServerToolConfiguration|array|null $toolConfiguration
    ): self {
        $obj = clone $this;
        $obj['toolConfiguration'] = $toolConfiguration;

        return $obj;
    }
}
