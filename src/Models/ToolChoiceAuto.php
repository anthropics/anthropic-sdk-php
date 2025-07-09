<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class ToolChoiceAuto implements BaseModel
{
    use Model;

    #[Api]
    public string $type;

    #[Api('disable_parallel_tool_use', optional: true)]
    public ?bool $disableParallelToolUse;

    /**
     * @param string    $type
     * @param null|bool $disableParallelToolUse
     */
    final public function __construct(
        $type,
        $disableParallelToolUse = None::NOT_GIVEN
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

ToolChoiceAuto::_loadMetadata();
