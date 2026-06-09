<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List Deployment Runs.
 *
 * @see Anthropic\Services\Beta\DeploymentRunsService::list()
 *
 * @phpstan-type DeploymentRunListParamsShape = array{
 *   createdAtGt?: \DateTimeInterface|null,
 *   createdAtGte?: \DateTimeInterface|null,
 *   createdAtLt?: \DateTimeInterface|null,
 *   createdAtLte?: \DateTimeInterface|null,
 *   deploymentID?: string|null,
 *   hasError?: bool|null,
 *   limit?: int|null,
 *   page?: string|null,
 *   triggerType?: null|BetaManagedAgentsTriggerType|value-of<BetaManagedAgentsTriggerType>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class DeploymentRunListParams implements BaseModel
{
    /** @use SdkModel<DeploymentRunListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Return runs created strictly after this time (exclusive).
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtGt;

    /**
     * Return runs created at or after this time (inclusive).
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtGte;

    /**
     * Return runs created strictly before this time (exclusive).
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtLt;

    /**
     * Return runs created at or before this time (inclusive).
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtLte;

    /**
     * Filter to a specific deployment. Omit to list across all deployments in the workspace. Filtering by a non-existent deployment_id returns 200 with empty data.
     */
    #[Optional]
    public ?string $deploymentID;

    /**
     * Filter: true for runs with non-null error, false for runs with non-null session_id. Omit for all.
     */
    #[Optional]
    public ?bool $hasError;

    /**
     * Maximum results per page. Default 20, maximum 1000.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Opaque pagination cursor. Pass next_page from the previous response. Invalid or expired cursors return 400.
     */
    #[Optional]
    public ?string $page;

    /**
     * Filter runs by what triggered them. Omit to return all runs.
     *
     * @var value-of<BetaManagedAgentsTriggerType>|null $triggerType
     */
    #[Optional(enum: BetaManagedAgentsTriggerType::class)]
    public ?string $triggerType;

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
     * @param BetaManagedAgentsTriggerType|value-of<BetaManagedAgentsTriggerType>|null $triggerType
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?\DateTimeInterface $createdAtGt = null,
        ?\DateTimeInterface $createdAtGte = null,
        ?\DateTimeInterface $createdAtLt = null,
        ?\DateTimeInterface $createdAtLte = null,
        ?string $deploymentID = null,
        ?bool $hasError = null,
        ?int $limit = null,
        ?string $page = null,
        BetaManagedAgentsTriggerType|string|null $triggerType = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $createdAtGt && $self['createdAtGt'] = $createdAtGt;
        null !== $createdAtGte && $self['createdAtGte'] = $createdAtGte;
        null !== $createdAtLt && $self['createdAtLt'] = $createdAtLt;
        null !== $createdAtLte && $self['createdAtLte'] = $createdAtLte;
        null !== $deploymentID && $self['deploymentID'] = $deploymentID;
        null !== $hasError && $self['hasError'] = $hasError;
        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;
        null !== $triggerType && $self['triggerType'] = $triggerType;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Return runs created strictly after this time (exclusive).
     */
    public function withCreatedAtGt(\DateTimeInterface $createdAtGt): self
    {
        $self = clone $this;
        $self['createdAtGt'] = $createdAtGt;

        return $self;
    }

    /**
     * Return runs created at or after this time (inclusive).
     */
    public function withCreatedAtGte(\DateTimeInterface $createdAtGte): self
    {
        $self = clone $this;
        $self['createdAtGte'] = $createdAtGte;

        return $self;
    }

    /**
     * Return runs created strictly before this time (exclusive).
     */
    public function withCreatedAtLt(\DateTimeInterface $createdAtLt): self
    {
        $self = clone $this;
        $self['createdAtLt'] = $createdAtLt;

        return $self;
    }

    /**
     * Return runs created at or before this time (inclusive).
     */
    public function withCreatedAtLte(\DateTimeInterface $createdAtLte): self
    {
        $self = clone $this;
        $self['createdAtLte'] = $createdAtLte;

        return $self;
    }

    /**
     * Filter to a specific deployment. Omit to list across all deployments in the workspace. Filtering by a non-existent deployment_id returns 200 with empty data.
     */
    public function withDeploymentID(string $deploymentID): self
    {
        $self = clone $this;
        $self['deploymentID'] = $deploymentID;

        return $self;
    }

    /**
     * Filter: true for runs with non-null error, false for runs with non-null session_id. Omit for all.
     */
    public function withHasError(bool $hasError): self
    {
        $self = clone $this;
        $self['hasError'] = $hasError;

        return $self;
    }

    /**
     * Maximum results per page. Default 20, maximum 1000.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque pagination cursor. Pass next_page from the previous response. Invalid or expired cursors return 400.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Filter runs by what triggered them. Omit to return all runs.
     *
     * @param BetaManagedAgentsTriggerType|value-of<BetaManagedAgentsTriggerType> $triggerType
     */
    public function withTriggerType(
        BetaManagedAgentsTriggerType|string $triggerType
    ): self {
        $self = clone $this;
        $self['triggerType'] = $triggerType;

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
