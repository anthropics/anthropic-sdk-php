<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

final class BetaToolChoiceAuto implements BaseModel
{
    use Model;

    #[Api]
    public string $type;

    #[Api('disable_parallel_tool_use', optional: true)]
    public ?bool $disableParallelToolUse;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string    $type                   `required`
     * @param null|bool $disableParallelToolUse
     */
    final public function __construct(
        $type,
        $disableParallelToolUse = None::NOT_GIVEN
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaToolChoiceAuto::_loadMetadata();
