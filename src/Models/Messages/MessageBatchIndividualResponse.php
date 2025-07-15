<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string                                                                                                     $customID `required`
     * @param MessageBatchCanceledResult|MessageBatchErroredResult|MessageBatchExpiredResult|MessageBatchSucceededResult $result   `required`
     */
    final public function __construct($customID, $result)
    {
        $this->constructFromArgs(func_get_args());
    }
}

MessageBatchIndividualResponse::_loadMetadata();
