<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class RawMessageDeltaEvent implements BaseModel
{
    use Model;

    /**
     * @var array{stopReason?: string, stopSequence?: null|string} $delta
     */
    #[Api]
    public array $delta;

    #[Api]
    public string $type;

    #[Api]
    public MessageDeltaUsage $usage;

    /**
     * @param array{stopReason?: string, stopSequence?: null|string} $delta
     */
    final public function __construct(
        array $delta,
        string $type,
        MessageDeltaUsage $usage
    ) {
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

RawMessageDeltaEvent::_loadMetadata();
