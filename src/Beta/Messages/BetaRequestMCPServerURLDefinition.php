<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRequestMCPServerURLDefinitionShape = array{
 *   name: string,
 *   type: 'url',
 *   url: string,
 *   authorization_token?: string|null,
 *   tool_configuration?: BetaRequestMCPServerToolConfiguration|null,
 * }
 */
final class BetaRequestMCPServerURLDefinition implements BaseModel
{
    /** @use SdkModel<BetaRequestMCPServerURLDefinitionShape> */
    use SdkModel;

    /** @var 'url' $type */
    #[Api]
    public string $type = 'url';

    #[Api]
    public string $name;

    #[Api]
    public string $url;

    #[Api(nullable: true, optional: true)]
    public ?string $authorization_token;

    #[Api(nullable: true, optional: true)]
    public ?BetaRequestMCPServerToolConfiguration $tool_configuration;

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
     *   allowed_tools?: list<string>|null, enabled?: bool|null
     * }|null $tool_configuration
     */
    public static function with(
        string $name,
        string $url,
        ?string $authorization_token = null,
        BetaRequestMCPServerToolConfiguration|array|null $tool_configuration = null,
    ): self {
        $obj = new self;

        $obj['name'] = $name;
        $obj['url'] = $url;

        null !== $authorization_token && $obj['authorization_token'] = $authorization_token;
        null !== $tool_configuration && $obj['tool_configuration'] = $tool_configuration;

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
        $obj['authorization_token'] = $authorizationToken;

        return $obj;
    }

    /**
     * @param BetaRequestMCPServerToolConfiguration|array{
     *   allowed_tools?: list<string>|null, enabled?: bool|null
     * }|null $toolConfiguration
     */
    public function withToolConfiguration(
        BetaRequestMCPServerToolConfiguration|array|null $toolConfiguration
    ): self {
        $obj = clone $this;
        $obj['tool_configuration'] = $toolConfiguration;

        return $obj;
    }
}
