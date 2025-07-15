<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaRawMessageDeltaEvent;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaContainer;

class Delta implements BaseModel
{
    use Model;

    #[Api]
    public BetaContainer $container;

    #[Api('stop_reason')]
    public string $stopReason;

    #[Api('stop_sequence')]
    public ?string $stopSequence;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param BetaContainer $container    `required`
     * @param string        $stopReason   `required`
     * @param null|string   $stopSequence `required`
     */
    final public function __construct($container, $stopReason, $stopSequence)
    {
        $this->constructFromArgs(func_get_args());
    }
}

Delta::_loadMetadata();
