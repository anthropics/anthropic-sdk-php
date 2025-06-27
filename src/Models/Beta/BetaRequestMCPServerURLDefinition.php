<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

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
    public BetaRequestMCPServerToolConfiguration $toolConfiguration;

    /**
     * @param string|null                           $authorizationToken
     * @param BetaRequestMCPServerToolConfiguration $toolConfiguration
     */
    final public function __construct(
        string $name,
        string $type,
        string $url,
        string|None|null $authorizationToken = None::NOT_SET,
        BetaRequestMCPServerToolConfiguration|None $toolConfiguration = None::NOT_SET,
    ) {

        $args = func_get_args();

        $data = [];
        for ($i = 0; $i < count($args); ++$i) {
            if (None::NOT_SET !== $args[$i]) {
                $data[self::$_constructorArgNames[$i]] = $args[$i] ?? null;
            }
        }

        $this->__unserialize($data);

    }
}

BetaRequestMCPServerURLDefinition::_loadMetadata();
