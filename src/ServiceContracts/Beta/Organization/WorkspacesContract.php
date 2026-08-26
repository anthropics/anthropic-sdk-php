<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Workspaces\DataResidencyCreateConfig;
use Anthropic\Beta\Organization\Workspaces\DataResidencyUpdateConfig;
use Anthropic\Beta\Organization\Workspaces\Workspace;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Page;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type DataResidencyCreateConfigShape from \Anthropic\Beta\Organization\Workspaces\DataResidencyCreateConfig
 * @phpstan-import-type DataResidencyUpdateConfigShape from \Anthropic\Beta\Organization\Workspaces\DataResidencyUpdateConfig
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface WorkspacesContract
{
    /**
     * @api
     *
     * @param string $name body param: Name of the Workspace
     * @param DataResidencyCreateConfig|DataResidencyCreateConfigShape|null $dataResidency Body param: Data residency configuration for the workspace. If omitted, defaults to `workspace_geo: "us"`, `allowed_inference_geos: "unrestricted"`, and `default_inference_geo: "global"`.
     * @param string|null $displayColor body param: Hex color code representing the Workspace in the Anthropic Console
     * @param string|null $externalKeyID Body param: ID of the customer-managed encryption key (CMEK) configuration to use for this
     * Workspace. Setting this field requires CMEK to be enabled for your
     * organization. When set, data stored for this Workspace is encrypted with the
     * referenced key. Create key configurations with the External Keys API. This
     * field is write-once: once a key is attached to a Workspace it cannot be
     * detached or replaced. To rotate key material, rotate the underlying key on
     * your cloud KMS; the `external_key_id` stays the same.
     * @param array<string,string>|null $tags Body param: User-defined tags as string key-value pairs. Keys may not begin with `anthropic`.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $name,
        DataResidencyCreateConfig|array|null $dataResidency = null,
        ?string $displayColor = null,
        ?string $externalKeyID = null,
        ?array $tags = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): Workspace;

    /**
     * @api
     *
     * @param string $workspaceID ID of the Workspace
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null
    ): Workspace;

    /**
     * @api
     *
     * @param DataResidencyUpdateConfig|DataResidencyUpdateConfigShape|null $dataResidency data residency configuration for the workspace
     * @param string $displayColor hex color code representing the Workspace in the Anthropic Console
     * @param string $externalKeyID ID of the customer-managed encryption key (CMEK) configuration to use for this
     * Workspace. Setting this field requires CMEK to be enabled for your
     * organization. When set, data stored for this Workspace is encrypted with the
     * referenced key. Create key configurations with the External Keys API. This
     * field is write-once: once a key is attached to a Workspace it cannot be
     * detached or replaced. To rotate key material, rotate the underlying key on
     * your cloud KMS; the `external_key_id` stays the same.
     * @param string $name name of the Workspace
     * @param array<string,string|null>|null $tags User-defined tags as string key-value pairs. Keys may not begin with `anthropic`.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $workspaceID,
        DataResidencyUpdateConfig|array|null $dataResidency = null,
        ?string $displayColor = null,
        ?string $externalKeyID = null,
        ?string $name = null,
        ?array $tags = null,
        RequestOptions|array|null $requestOptions = null,
    ): Workspace;

    /**
     * @api
     *
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param bool $includeArchived Whether to include Workspaces that have been archived in the response
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param RequestOpts|null $requestOptions
     *
     * @return Page<Workspace>
     *
     * @throws APIException
     */
    public function list(
        ?string $afterID = null,
        ?string $beforeID = null,
        ?bool $includeArchived = null,
        ?int $limit = null,
        RequestOptions|array|null $requestOptions = null,
    ): Page;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null
    ): Workspace;
}
