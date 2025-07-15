<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaRawMessageDeltaEvent\Delta;

final class BetaRawMessageDeltaEvent implements BaseModel
{
    use Model;

    #[Api]
    public Delta $delta;

    #[Api]
    public string $type = 'message_delta';

    #[Api]
    public BetaMessageDeltaUsage $usage;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param Delta                 $delta `required`
     * @param string                $type  `required`
     * @param BetaMessageDeltaUsage $usage `required`
     */
    final public function __construct($delta, $usage, $type = 'message_delta')
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaRawMessageDeltaEvent::_loadMetadata();
