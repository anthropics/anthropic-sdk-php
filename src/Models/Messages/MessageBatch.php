<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class MessageBatch implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api('archived_at')]
    public ?\DateTimeInterface $archivedAt;

    #[Api('cancel_initiated_at')]
    public ?\DateTimeInterface $cancelInitiatedAt;

    #[Api('created_at')]
    public \DateTimeInterface $createdAt;

    #[Api('ended_at')]
    public ?\DateTimeInterface $endedAt;

    #[Api('expires_at')]
    public \DateTimeInterface $expiresAt;

    #[Api('processing_status')]
    public string $processingStatus;

    #[Api('request_counts')]
    public MessageBatchRequestCounts $requestCounts;

    #[Api('results_url')]
    public ?string $resultsURL;

    #[Api]
    public string $type;

    /**
     * @param string                    $id
     * @param null|\DateTimeInterface   $archivedAt
     * @param null|\DateTimeInterface   $cancelInitiatedAt
     * @param \DateTimeInterface        $createdAt
     * @param null|\DateTimeInterface   $endedAt
     * @param \DateTimeInterface        $expiresAt
     * @param string                    $processingStatus
     * @param MessageBatchRequestCounts $requestCounts
     * @param null|string               $resultsURL
     * @param string                    $type
     */
    final public function __construct(
        $id,
        $archivedAt,
        $cancelInitiatedAt,
        $createdAt,
        $endedAt,
        $expiresAt,
        $processingStatus,
        $requestCounts,
        $resultsURL,
        $type,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

MessageBatch::_loadMetadata();
