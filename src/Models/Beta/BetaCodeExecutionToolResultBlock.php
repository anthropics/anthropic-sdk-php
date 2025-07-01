<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class BetaCodeExecutionToolResultBlock implements BaseModel
{
    use Model;

    /**
     * @var BetaCodeExecutionResultBlock|BetaCodeExecutionToolResultError $content
     */
    #[Api]
    public mixed $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api]
    public string $type;

    /**
     * @param BetaCodeExecutionResultBlock|BetaCodeExecutionToolResultError $content
     */
    final public function __construct(
        mixed $content,
        string $toolUseID,
        string $type
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

BetaCodeExecutionToolResultBlock::_loadMetadata();
