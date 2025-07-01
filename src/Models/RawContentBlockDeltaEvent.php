<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

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
     */
    final public function __construct(mixed $delta, int $index, string $type)
    {
        $args = func_get_args();

        $data = [];
        for ($i = 0; $i < count($args); ++$i) {
            if (None::NOT_SET !== $args[$i]) {
                $data[self::$_constructorArgNames[$i]] = $args[$i] ?? null;
            }
        }

        $this->__unserialize($data);
    }
}

RawContentBlockDeltaEvent::_loadMetadata();
