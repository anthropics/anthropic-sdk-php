<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\Messages\BetaMessageBatchErroredResult\Type;
use Anthropic\Models\BetaErrorResponse;

final class BetaMessageBatchErroredResult implements BaseModel
{
    use Model;

    #[Api]
    public BetaErrorResponse $error;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'errored';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        BetaErrorResponse $error,
        string $type = 'errored'
    ) {
        $this->error = $error;
        $this->type = $type;
    }
}

BetaMessageBatchErroredResult::_loadMetadata();
