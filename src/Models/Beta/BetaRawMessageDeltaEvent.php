<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class BetaRawMessageDeltaEvent implements BaseModel
{
    use Model;

    /**
     * @var array{
     *
     * container?: BetaContainer, stopReason?: string, stopSequence?: string|null
     *
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
     *
     * container?: BetaContainer, stopReason?: string, stopSequence?: string|null
     *
     * } $delta
     */
    final public function __construct(
        array $delta,
        string $type,
        BetaMessageDeltaUsage $usage
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

BetaRawMessageDeltaEvent::_loadMetadata();
