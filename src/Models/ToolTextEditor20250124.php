<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class ToolTextEditor20250124 implements BaseModel
{
    use Model;

    #[Api]
    public string $name;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string                $name         `required`
     * @param string                $type         `required`
     * @param CacheControlEphemeral $cacheControl
     */
    final public function __construct(
        $name,
        $type,
        $cacheControl = None::NOT_GIVEN
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

ToolTextEditor20250124::_loadMetadata();
