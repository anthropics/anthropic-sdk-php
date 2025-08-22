<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

final class BetaRequestMCPServerURLDefinition implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'url';

    #[Api]
    public string $name;

    #[Api]
    public string $url;

    #[Api('authorization_token', optional: true)]
    public ?string $authorizationToken;

    #[Api('tool_configuration', optional: true)]
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        string $name,
        string $url,
        ?string $authorizationToken = null,
        ?BetaRequestMCPServerToolConfiguration $toolConfiguration = null,
    ): self {
        $obj = new self;

        $obj->name = $name;
        $obj->url = $url;

        null !== $authorizationToken && $obj->authorizationToken = $authorizationToken;
        null !== $toolConfiguration && $obj->toolConfiguration = $toolConfiguration;

        return $obj;
    }

    public function withName(string $name): self
    {
        $obj = clone $this;
        $obj->name = $name;

        return $obj;
    }

    public function withURL(string $url): self
    {
        $obj = clone $this;
        $obj->url = $url;

        return $obj;
    }

    public function withAuthorizationToken(?string $authorizationToken): self
    {
        $obj = clone $this;
        $obj->authorizationToken = $authorizationToken;

        return $obj;
    }

    public function withToolConfiguration(
        BetaRequestMCPServerToolConfiguration $toolConfiguration
    ): self {
        $obj = clone $this;
        $obj->toolConfiguration = $toolConfiguration;

        return $obj;
    }
}
