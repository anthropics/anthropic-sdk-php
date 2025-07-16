<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaRawMessageStartEvent implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'message_start';

    #[Api]
    public BetaMessage $message;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(BetaMessage $message)
    {
        $this->message = $message;
    }
}

BetaRawMessageStartEvent::__introspect();
