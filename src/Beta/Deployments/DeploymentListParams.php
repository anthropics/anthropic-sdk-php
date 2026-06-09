<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List Deployments.
 *
 * @see Anthropic\Services\Beta\DeploymentsService::list()
 *
 * @phpstan-type DeploymentListParamsShape = array{
 *   agentID?: string|null,
 *   createdAtGte?: \DateTimeInterface|null,
 *   createdAtLte?: \DateTimeInterface|null,
 *   includeArchived?: bool|null,
 *   limit?: int|null,
 *   page?: string|null,
 *   status?: null|BetaManagedAgentsDeploymentStatus|value-of<BetaManagedAgentsDeploymentStatus>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class DeploymentListParams implements BaseModel
{
    /** @use SdkModel<DeploymentListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Filter by agent ID.
     */
    #[Optional]
    public ?string $agentID;

    /**
     * Return deployments created at or after this time (inclusive).
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtGte;

    /**
     * Return deployments created at or before this time (inclusive).
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtLte;

    /**
     * When true, includes archived deployments. Default: false (exclude archived).
     */
    #[Optional]
    public ?bool $includeArchived;

    /**
     * Maximum results per page. Default 20, maximum 100.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Opaque pagination cursor.
     */
    #[Optional]
    public ?string $page;

    /**
     * Filter by status: active or paused. Omit for both. To include archived deployments, use include_archived instead; the two cannot be combined.
     *
     * @var value-of<BetaManagedAgentsDeploymentStatus>|null $status
     */
    #[Optional(enum: BetaManagedAgentsDeploymentStatus::class)]
    public ?string $status;

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
     * @param BetaManagedAgentsDeploymentStatus|value-of<BetaManagedAgentsDeploymentStatus>|null $status
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?string $agentID = null,
        ?\DateTimeInterface $createdAtGte = null,
        ?\DateTimeInterface $createdAtLte = null,
        ?bool $includeArchived = null,
        ?int $limit = null,
        ?string $page = null,
        BetaManagedAgentsDeploymentStatus|string|null $status = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $agentID && $self['agentID'] = $agentID;
        null !== $createdAtGte && $self['createdAtGte'] = $createdAtGte;
        null !== $createdAtLte && $self['createdAtLte'] = $createdAtLte;
        null !== $includeArchived && $self['includeArchived'] = $includeArchived;
        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;
        null !== $status && $self['status'] = $status;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Filter by agent ID.
     */
    public function withAgentID(string $agentID): self
    {
        $self = clone $this;
        $self['agentID'] = $agentID;

        return $self;
    }

    /**
     * Return deployments created at or after this time (inclusive).
     */
    public function withCreatedAtGte(\DateTimeInterface $createdAtGte): self
    {
        $self = clone $this;
        $self['createdAtGte'] = $createdAtGte;

        return $self;
    }

    /**
     * Return deployments created at or before this time (inclusive).
     */
    public function withCreatedAtLte(\DateTimeInterface $createdAtLte): self
    {
        $self = clone $this;
        $self['createdAtLte'] = $createdAtLte;

        return $self;
    }

    /**
     * When true, includes archived deployments. Default: false (exclude archived).
     */
    public function withIncludeArchived(bool $includeArchived): self
    {
        $self = clone $this;
        $self['includeArchived'] = $includeArchived;

        return $self;
    }

    /**
     * Maximum results per page. Default 20, maximum 100.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque pagination cursor.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Filter by status: active or paused. Omit for both. To include archived deployments, use include_archived instead; the two cannot be combined.
     *
     * @param BetaManagedAgentsDeploymentStatus|value-of<BetaManagedAgentsDeploymentStatus> $status
     */
    public function withStatus(
        BetaManagedAgentsDeploymentStatus|string $status
    ): self {
        $self = clone $this;
        $self['status'] = $status;

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
