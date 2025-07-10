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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string                    $id                `required`
     * @param null|\DateTimeInterface   $archivedAt        `required`
     * @param null|\DateTimeInterface   $cancelInitiatedAt `required`
     * @param \DateTimeInterface        $createdAt         `required`
     * @param null|\DateTimeInterface   $endedAt           `required`
     * @param \DateTimeInterface        $expiresAt         `required`
     * @param string                    $processingStatus  `required`
     * @param MessageBatchRequestCounts $requestCounts     `required`
     * @param null|string               $resultsURL        `required`
     * @param string                    $type              `required`
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
