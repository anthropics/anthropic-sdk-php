<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class RawMessageDeltaEvent implements BaseModel
{
    use Model;

    /** @var array{stopReason?: string, stopSequence?: null|string} $delta */
    #[Api]
    public array $delta;

    #[Api]
    public string $type;

    #[Api]
    public MessageDeltaUsage $usage;

    /**
     * @param array{stopReason?: string, stopSequence?: null|string} $delta
     * @param string                                                 $type
     * @param MessageDeltaUsage                                      $usage
     */
    final public function __construct($delta, $type, $usage)
    {
        $this->constructFromArgs(func_get_args());
    }
}

RawMessageDeltaEvent::_loadMetadata();
