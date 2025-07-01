<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class BetaToolChoiceTool implements BaseModel
{
    use Model;

    #[Api]
    public string $name;

    #[Api]
    public string $type;

    #[Api('disable_parallel_tool_use', optional: true)]
    public bool $disableParallelToolUse;

    /**
     * @param bool $disableParallelToolUse
     */
    final public function __construct(
        string $name,
        string $type,
        bool|None $disableParallelToolUse = None::NOT_SET
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

BetaToolChoiceTool::_loadMetadata();
