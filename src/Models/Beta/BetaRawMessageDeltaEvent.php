<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaRawMessageDeltaEvent implements BaseModel
{
    use Model;

    /**
     * @var array{
     *   container?: BetaContainer, stopReason?: string, stopSequence?: string|null
     * } $delta
     */
    #[Api]
    public array $delta;

    #[Api]
    public string $type;

    #[Api]
    public BetaMessageDeltaUsage $usage;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param array{
     *   container?: BetaContainer, stopReason?: string, stopSequence?: string|null
     * } $delta `required`
     * @param string                $type  `required`
     * @param BetaMessageDeltaUsage $usage `required`
     */
    final public function __construct($delta, $type, $usage)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaRawMessageDeltaEvent::_loadMetadata();
