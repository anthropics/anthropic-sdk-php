<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaMessageBatchIndividualResponse implements BaseModel
{
    use Model;

    #[Api('custom_id')]
    public string $customID;

    #[Api]
    public BetaMessageBatchCanceledResult|BetaMessageBatchErroredResult|BetaMessageBatchExpiredResult|BetaMessageBatchSucceededResult $result;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $customID,
        BetaMessageBatchCanceledResult|BetaMessageBatchErroredResult|BetaMessageBatchExpiredResult|BetaMessageBatchSucceededResult $result,
    ) {
        $this->customID = $customID;
        $this->result = $result;
    }
}

BetaMessageBatchIndividualResponse::__introspect();
