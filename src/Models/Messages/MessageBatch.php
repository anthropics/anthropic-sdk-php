<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Messages\MessageBatch\ProcessingStatus;
use Anthropic\Models\Messages\MessageBatch\Type;

final class MessageBatch implements BaseModel
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

    /** @var ProcessingStatus::* $processingStatus */
    #[Api('processing_status')]
    public string $processingStatus;

    #[Api('request_counts')]
    public MessageBatchRequestCounts $requestCounts;

    #[Api('results_url')]
    public ?string $resultsURL;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'message_batch';

    /**
     * You must use named parameters to construct this object.
     *
     * @param ProcessingStatus::* $processingStatus
     * @param Type::*             $type
     */
    final public function __construct(
        string $id,
        ?\DateTimeInterface $archivedAt,
        ?\DateTimeInterface $cancelInitiatedAt,
        \DateTimeInterface $createdAt,
        ?\DateTimeInterface $endedAt,
        \DateTimeInterface $expiresAt,
        string $processingStatus,
        MessageBatchRequestCounts $requestCounts,
        ?string $resultsURL,
        string $type = 'message_batch',
    ) {
        $this->id = $id;
        $this->archivedAt = $archivedAt;
        $this->cancelInitiatedAt = $cancelInitiatedAt;
        $this->createdAt = $createdAt;
        $this->endedAt = $endedAt;
        $this->expiresAt = $expiresAt;
        $this->processingStatus = $processingStatus;
        $this->requestCounts = $requestCounts;
        $this->resultsURL = $resultsURL;
        $this->type = $type;
    }
}

MessageBatch::_loadMetadata();
