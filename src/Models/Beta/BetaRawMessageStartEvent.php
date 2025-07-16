<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaRawMessageStartEvent\Type;

final class BetaRawMessageStartEvent implements BaseModel
{
    use Model;

    #[Api]
    public BetaMessage $message;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'message_start';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        BetaMessage $message,
        string $type = 'message_start'
    ) {
        $this->message = $message;
        $this->type = $type;
    }
}

BetaRawMessageStartEvent::_loadMetadata();
