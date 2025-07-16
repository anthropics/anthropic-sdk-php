<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\Messages\MessageBatch\ProcessingStatus;

final class MessageBatch implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'message_batch';

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

    /**
     * You must use named parameters to construct this object.
     *
     * @param ProcessingStatus::* $processingStatus
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

        self::_introspect();
    }
}
