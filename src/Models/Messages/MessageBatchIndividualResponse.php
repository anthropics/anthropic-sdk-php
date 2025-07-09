<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class MessageBatchIndividualResponse implements BaseModel
{
    use Model;

    #[Api('custom_id')]
    public string $customID;

    /**
     * @var MessageBatchCanceledResult|MessageBatchErroredResult|MessageBatchExpiredResult|MessageBatchSucceededResult $result
     */
    #[Api]
    public mixed $result;

    /**
     * @param string                                                                                                     $customID
     * @param MessageBatchCanceledResult|MessageBatchErroredResult|MessageBatchExpiredResult|MessageBatchSucceededResult $result
     */
    final public function __construct($customID, $result)
    {
        $this->constructFromArgs(func_get_args());
    }
}

MessageBatchIndividualResponse::_loadMetadata();
