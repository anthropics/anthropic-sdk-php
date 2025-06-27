<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaRawContentBlockDeltaEvent implements BaseModel
{
    use Model;

    /**
     * @var BetaTextDelta|BetaInputJSONDelta|BetaCitationsDelta|BetaThinkingDelta|BetaSignatureDelta $delta
     */
    #[Api]
    public mixed $delta;

    #[Api]
    public int $index;

    #[Api]
    public string $type;

    /**
     * @param BetaTextDelta|BetaInputJSONDelta|BetaCitationsDelta|BetaThinkingDelta|BetaSignatureDelta $delta
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

BetaRawContentBlockDeltaEvent::_loadMetadata();
