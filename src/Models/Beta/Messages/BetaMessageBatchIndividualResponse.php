<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaMessageBatchIndividualResponse implements BaseModel
{
    use Model;

    #[Api('custom_id')]
    public string $customID;

    /**
     * @var BetaMessageBatchCanceledResult|BetaMessageBatchErroredResult|BetaMessageBatchExpiredResult|BetaMessageBatchSucceededResult $result
     */
    #[Api]
    public mixed $result;

    /**
     * @param string                                                                                                                     $customID
     * @param BetaMessageBatchCanceledResult|BetaMessageBatchErroredResult|BetaMessageBatchExpiredResult|BetaMessageBatchSucceededResult $result
     */
    final public function __construct($customID, $result)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaMessageBatchIndividualResponse::_loadMetadata();
