<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_request_mcp_server_url_definition_alias = array{
 *   name: string,
 *   type: string,
 *   url: string,
 *   authorizationToken?: string|null,
 *   toolConfiguration?: BetaRequestMCPServerToolConfiguration,
 * }
 */
final class BetaRequestMCPServerURLDefinition implements BaseModel
{
    use Model;

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
    public static function new(
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

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setURL(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function setAuthorizationToken(?string $authorizationToken): self
    {
        $this->authorizationToken = $authorizationToken;

        return $this;
    }

    public function setToolConfiguration(
        BetaRequestMCPServerToolConfiguration $toolConfiguration
    ): self {
        $this->toolConfiguration = $toolConfiguration;

        return $this;
    }
}
