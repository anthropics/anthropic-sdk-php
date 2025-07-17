<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class MessageBatchIndividualResponse implements BaseModel
{
    use Model;

    #[Api('custom_id')]
    public string $customID;

    #[Api]
    public MessageBatchCanceledResult|MessageBatchErroredResult|MessageBatchExpiredResult|MessageBatchSucceededResult $result;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $customID,
        MessageBatchCanceledResult|MessageBatchErroredResult|MessageBatchExpiredResult|MessageBatchSucceededResult $result,
    ) {
        self::introspect();

        $this->customID = $customID;
        $this->result = $result;
    }
}
