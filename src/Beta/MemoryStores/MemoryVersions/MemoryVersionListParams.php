<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryView;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * ListMemoryVersions.
 *
 * @see Anthropic\Services\Beta\MemoryStores\MemoryVersionsService::list()
 *
 * @phpstan-type MemoryVersionListParamsShape = array{
 *   apiKeyID?: string|null,
 *   createdAtGte?: \DateTimeInterface|null,
 *   createdAtLte?: \DateTimeInterface|null,
 *   limit?: int|null,
 *   memoryID?: string|null,
 *   operation?: null|ManagedAgentsMemoryVersionOperation|value-of<ManagedAgentsMemoryVersionOperation>,
 *   page?: string|null,
 *   sessionID?: string|null,
 *   view?: null|ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class MemoryVersionListParams implements BaseModel
{
    /** @use SdkModel<MemoryVersionListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Query parameter for api_key_id.
     */
    #[Optional]
    public ?string $apiKeyID;

    /**
     * Return versions created at or after this time (inclusive).
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtGte;

    /**
     * Return versions created at or before this time (inclusive).
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtLte;

    /**
     * Query parameter for limit.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Query parameter for memory_id.
     */
    #[Optional]
    public ?string $memoryID;

    /**
     * Query parameter for operation.
     *
     * @var value-of<ManagedAgentsMemoryVersionOperation>|null $operation
     */
    #[Optional(enum: ManagedAgentsMemoryVersionOperation::class)]
    public ?string $operation;

    /**
     * Query parameter for page.
     */
    #[Optional]
    public ?string $page;

    /**
     * Query parameter for session_id.
     */
    #[Optional]
    public ?string $sessionID;

    /**
     * Query parameter for view.
     *
     * @var value-of<ManagedAgentsMemoryView>|null $view
     */
    #[Optional(enum: ManagedAgentsMemoryView::class)]
    public ?string $view;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ManagedAgentsMemoryVersionOperation|value-of<ManagedAgentsMemoryVersionOperation>|null $operation
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>|null $view
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?string $apiKeyID = null,
        ?\DateTimeInterface $createdAtGte = null,
        ?\DateTimeInterface $createdAtLte = null,
        ?int $limit = null,
        ?string $memoryID = null,
        ManagedAgentsMemoryVersionOperation|string|null $operation = null,
        ?string $page = null,
        ?string $sessionID = null,
        ManagedAgentsMemoryView|string|null $view = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $apiKeyID && $self['apiKeyID'] = $apiKeyID;
        null !== $createdAtGte && $self['createdAtGte'] = $createdAtGte;
        null !== $createdAtLte && $self['createdAtLte'] = $createdAtLte;
        null !== $limit && $self['limit'] = $limit;
        null !== $memoryID && $self['memoryID'] = $memoryID;
        null !== $operation && $self['operation'] = $operation;
        null !== $page && $self['page'] = $page;
        null !== $sessionID && $self['sessionID'] = $sessionID;
        null !== $view && $self['view'] = $view;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Query parameter for api_key_id.
     */
    public function withAPIKeyID(string $apiKeyID): self
    {
        $self = clone $this;
        $self['apiKeyID'] = $apiKeyID;

        return $self;
    }

    /**
     * Return versions created at or after this time (inclusive).
     */
    public function withCreatedAtGte(\DateTimeInterface $createdAtGte): self
    {
        $self = clone $this;
        $self['createdAtGte'] = $createdAtGte;

        return $self;
    }

    /**
     * Return versions created at or before this time (inclusive).
     */
    public function withCreatedAtLte(\DateTimeInterface $createdAtLte): self
    {
        $self = clone $this;
        $self['createdAtLte'] = $createdAtLte;

        return $self;
    }

    /**
     * Query parameter for limit.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Query parameter for memory_id.
     */
    public function withMemoryID(string $memoryID): self
    {
        $self = clone $this;
        $self['memoryID'] = $memoryID;

        return $self;
    }

    /**
     * Query parameter for operation.
     *
     * @param ManagedAgentsMemoryVersionOperation|value-of<ManagedAgentsMemoryVersionOperation> $operation
     */
    public function withOperation(
        ManagedAgentsMemoryVersionOperation|string $operation
    ): self {
        $self = clone $this;
        $self['operation'] = $operation;

        return $self;
    }

    /**
     * Query parameter for page.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Query parameter for session_id.
     */
    public function withSessionID(string $sessionID): self
    {
        $self = clone $this;
        $self['sessionID'] = $sessionID;

        return $self;
    }

    /**
     * Query parameter for view.
     *
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view
     */
    public function withView(ManagedAgentsMemoryView|string $view): self
    {
        $self = clone $this;
        $self['view'] = $view;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
