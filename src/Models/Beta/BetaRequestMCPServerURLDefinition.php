<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

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

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $name,
        string $url,
        ?string $authorizationToken = null,
        ?BetaRequestMCPServerToolConfiguration $toolConfiguration = null,
    ) {
        $this->name = $name;
        $this->url = $url;

        self::_introspect();
        $this->unsetOptionalProperties();

        null != $authorizationToken && $this->authorizationToken = $authorizationToken;
        null != $toolConfiguration && $this->toolConfiguration = $toolConfiguration;
    }
}
