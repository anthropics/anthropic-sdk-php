<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\RawMessageDeltaEvent\Delta;

class RawMessageDeltaEvent implements BaseModel
{
    use Model;

    #[Api]
    public Delta $delta;

    #[Api]
    public string $type;

    #[Api]
    public MessageDeltaUsage $usage;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param Delta             $delta `required`
     * @param string            $type  `required`
     * @param MessageDeltaUsage $usage `required`
     */
    final public function __construct($delta, $type, $usage)
    {
        $this->constructFromArgs(func_get_args());
    }
}

RawMessageDeltaEvent::_loadMetadata();
