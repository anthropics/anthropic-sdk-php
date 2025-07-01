<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class BetaRequestMCPServerToolConfiguration implements BaseModel
{
    use Model;

    /**
     * @var null|list<string> $allowedTools
     */
    #[Api(
        'allowed_tools',
        type: new UnionOf([new ListOf('string'), 'null']),
        optional: true,
    )]
    public ?array $allowedTools;

    #[Api(optional: true)]
    public ?bool $enabled;

    /**
     * @param null|list<string> $allowedTools
     * @param null|bool         $enabled
     */
    final public function __construct(
        null|array|None $allowedTools = None::NOT_SET,
        null|bool|None $enabled = None::NOT_SET
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

BetaRequestMCPServerToolConfiguration::_loadMetadata();
