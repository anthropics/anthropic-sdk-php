<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class RawContentBlockDeltaEvent implements BaseModel
{
    use Model;

    /**
     * @var CitationsDelta|InputJSONDelta|SignatureDelta|TextDelta|ThinkingDelta $delta
     */
    #[Api]
    public mixed $delta;

    #[Api]
    public int $index;

    #[Api]
    public string $type;

    /**
     * @param CitationsDelta|InputJSONDelta|SignatureDelta|TextDelta|ThinkingDelta $delta
     * @param int                                                                  $index
     * @param string                                                               $type
     */
    final public function __construct($delta, $index, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

RawContentBlockDeltaEvent::_loadMetadata();
