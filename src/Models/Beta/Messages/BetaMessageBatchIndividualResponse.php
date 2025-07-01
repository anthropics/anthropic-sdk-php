<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

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
     * @param BetaMessageBatchCanceledResult|BetaMessageBatchErroredResult|BetaMessageBatchExpiredResult|BetaMessageBatchSucceededResult $result
     */
    final public function __construct(string $customID, mixed $result)
    {
        $args = func_get_args();

        $data = [];
        for ($i = 0; $i < count($args); ++$i) {
            if (None::NOT_SET !== $args[$i]) {
                $data[self::$_constructorArgNames[$i]] = $args[$i] ?? null;
            }
        }

        $this->__unserialize($data);
    }
}

BetaMessageBatchIndividualResponse::_loadMetadata();
