<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsDeploymentRun;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsTriggerType;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface DeploymentRunsContract
{
    /**
     * @api
     *
     * @param string $deploymentRunID Path parameter deployment_run_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $deploymentRunID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsDeploymentRun;

    /**
     * @api
     *
     * @param \DateTimeInterface $createdAtGt query param: Return runs created strictly after this time (exclusive)
     * @param \DateTimeInterface $createdAtGte query param: Return runs created at or after this time (inclusive)
     * @param \DateTimeInterface $createdAtLt query param: Return runs created strictly before this time (exclusive)
     * @param \DateTimeInterface $createdAtLte query param: Return runs created at or before this time (inclusive)
     * @param string $deploymentID Query param: Filter to a specific deployment. Omit to list across all deployments in the workspace. Filtering by a non-existent deployment_id returns 200 with empty data.
     * @param bool $hasError Query param: Filter: true for runs with non-null error, false for runs with non-null session_id. Omit for all.
     * @param int $limit Query param: Maximum results per page. Default 20, maximum 1000.
     * @param string $page Query param: Opaque pagination cursor. Pass next_page from the previous response. Invalid or expired cursors return 400.
     * @param BetaManagedAgentsTriggerType|value-of<BetaManagedAgentsTriggerType> $triggerType Query param: Filter runs by what triggered them. Omit to return all runs.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaManagedAgentsDeploymentRun>
     *
     * @throws APIException
     */
    public function list(
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
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;
}
