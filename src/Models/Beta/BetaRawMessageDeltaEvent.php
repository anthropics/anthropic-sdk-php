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
     * @param array{
     *   container?: BetaContainer, stopReason?: string, stopSequence?: string|null
     * } $delta
     * @param string                $type
     * @param BetaMessageDeltaUsage $usage
     */
    final public function __construct($delta, $type, $usage)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaRawMessageDeltaEvent::_loadMetadata();
