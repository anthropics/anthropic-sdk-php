<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaRequestMCPServerURLDefinition\Type;

final class BetaRequestMCPServerURLDefinition implements BaseModel
{
    use Model;

    #[Api]
    public string $name;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    #[Api]
    public string $url;

    #[Api('authorization_token', optional: true)]
    public ?string $authorizationToken;

    #[Api('tool_configuration', optional: true)]
    public ?BetaRequestMCPServerToolConfiguration $toolConfiguration;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $name,
        string $type,
        string $url,
        ?string $authorizationToken = null,
        ?BetaRequestMCPServerToolConfiguration $toolConfiguration = null,
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->url = $url;
        $this->authorizationToken = $authorizationToken;
        $this->toolConfiguration = $toolConfiguration;
    }
}

BetaRequestMCPServerURLDefinition::_loadMetadata();
