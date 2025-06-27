<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Core\Serde\ListOf;

class BetaRequestMCPServerToolConfiguration implements BaseModel
{
    use Model;

    /**
     * @var list<string>|null $allowedTools
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
     * @param list<string>|null $allowedTools
     * @param bool|null         $enabled
     */
    final public function __construct(
        array|None|null $allowedTools = None::NOT_SET,
        bool|None|null $enabled = None::NOT_SET,
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
