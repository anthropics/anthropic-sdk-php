<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaMessageBatch implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    /**
     * @var mixed|null $archivedAt
     */
    #[Api('archived_at')]
    public mixed $archivedAt;

    /**
     * @var mixed|null $cancelInitiatedAt
     */
    #[Api('cancel_initiated_at')]
    public mixed $cancelInitiatedAt;

    #[Api('created_at')]
    public mixed $createdAt;

    /**
     * @var mixed|null $endedAt
     */
    #[Api('ended_at')]
    public mixed $endedAt;

    #[Api('expires_at')]
    public mixed $expiresAt;

    #[Api('processing_status')]
    public string $processingStatus;

    #[Api('request_counts')]
    public BetaMessageBatchRequestCounts $requestCounts;

    #[Api('results_url')]
    public ?string $resultsURL;

    #[Api]
    public string $type;

    /**
     * @param mixed|null $archivedAt
     * @param mixed|null $cancelInitiatedAt
     * @param mixed|null $endedAt
     */
    final public function __construct(
        string $id,
        mixed $archivedAt,
        mixed $cancelInitiatedAt,
        mixed $createdAt,
        mixed $endedAt,
        mixed $expiresAt,
        string $processingStatus,
        BetaMessageBatchRequestCounts $requestCounts,
        ?string $resultsURL,
        string $type,
    ) {

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

BetaMessageBatch::_loadMetadata();
