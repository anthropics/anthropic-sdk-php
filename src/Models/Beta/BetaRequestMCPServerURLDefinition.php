<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class BetaRequestMCPServerURLDefinition implements BaseModel
{
    use Model;

    #[Api]
    public string $name;

    #[Api]
    public string $type;

    #[Api]
    public string $url;

    #[Api('authorization_token', optional: true)]
    public ?string $authorizationToken;

    #[Api('tool_configuration', optional: true)]
    public ?BetaRequestMCPServerToolConfiguration $toolConfiguration;

    /**
     * @param string                                     $name
     * @param string                                     $type
     * @param string                                     $url
     * @param null|string                                $authorizationToken
     * @param null|BetaRequestMCPServerToolConfiguration $toolConfiguration
     */
    final public function __construct(
        $name,
        $type,
        $url,
        $authorizationToken = None::NOT_GIVEN,
        $toolConfiguration = None::NOT_GIVEN,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaRequestMCPServerURLDefinition::_loadMetadata();
