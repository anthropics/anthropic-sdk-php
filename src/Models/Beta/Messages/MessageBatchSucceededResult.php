<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaMessage;

final class MessageBatchSucceededResult implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'succeeded';

    #[Api]
    public BetaMessage $message;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(BetaMessage $message)
    {
        self::introspect();

        $this->message = $message;
    }
}
