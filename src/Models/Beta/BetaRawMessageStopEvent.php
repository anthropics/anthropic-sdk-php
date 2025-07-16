<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaRawMessageStopEvent\Type;

final class BetaRawMessageStopEvent implements BaseModel
{
    use Model;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'message_stop';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(string $type = 'message_stop')
    {
        $this->type = $type;
    }
}

BetaRawMessageStopEvent::_loadMetadata();
