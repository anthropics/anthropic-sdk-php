<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Workspaces\DataResidencyCreateConfig;
use Anthropic\Beta\Organization\Workspaces\DataResidencyUpdateConfig;
use Anthropic\Beta\Organization\Workspaces\Workspace;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Organization\ExternalKeys\ExternalKeyChangedException;
use Anthropic\Organization\ExternalKeys\ExternalKeyValidationFailedException;
use Anthropic\Organization\ExternalKeys\ExternalKeyValidationTimedOutException;
use Anthropic\Organization\Workspaces\KeyProfileMismatchException;
use Anthropic\Organization\Workspaces\WorkspacePolicyViolationException;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\WorkspacesContract;
use Anthropic\Services\Beta\Organization\Workspaces\MembersService;
use Anthropic\Services\Beta\Organization\Workspaces\RateLimitsService;
use Anthropic\Services\Beta\Organization\Workspaces\ServiceAccountsService;
use Anthropic\UserProfiles\UserProfileNotFoundException;

/**
 * @phpstan-import-type DataResidencyCreateConfigShape from \Anthropic\Beta\Organization\Workspaces\DataResidencyCreateConfig
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type DataResidencyUpdateConfigShape from \Anthropic\Beta\Organization\Workspaces\DataResidencyUpdateConfig
 */
final class WorkspacesService implements WorkspacesContract
{
    /**
     * @api
     */
    public WorkspacesRawService $raw;

    /**
     * @api
     */
    public RateLimitsService $rateLimits;

    /**
     * @api
     */
    public MembersService $members;

    /**
     * @api
     */
    public ServiceAccountsService $serviceAccounts;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new WorkspacesRawService($client);
        $this->rateLimits = new RateLimitsService($client);
        $this->members = new MembersService($client);
        $this->serviceAccounts = new ServiceAccountsService($client);
    }

    /**
     * @api
     *
     * Create Workspace
     *
     * @param string $name Body param: Name of the Workspace.
     * @param DataResidencyCreateConfig|DataResidencyCreateConfigShape|null $dataResidency Body param: Data residency configuration for the workspace. If omitted, defaults to `workspace_geo: "us"`, `allowed_inference_geos: "unrestricted"`, and `default_inference_geo: "global"`.
     * @param string|null $displayColor Body param: Hex color code representing the Workspace in the Anthropic Console.
     * @param string|null $externalKeyID Body param: ID of the customer-managed encryption key (CMEK) configuration to use for this
     * Workspace. Setting this field requires CMEK to be enabled for your
     * organization. When set, data stored for this Workspace is encrypted with the
     * referenced key. Create key configurations with the External Keys API. On
     * Claude Platform on AWS the value for an AWS KMS key is the key's ARN, and your
     * organization's own key must be a single-Region key in the same AWS account and
     * Region as the Workspace. On that platform the key is validated against this
     * Workspace when it is attached, so a key-policy problem is reported as an error
     * on this request. This field is write-once: once a key is attached to a Workspace
     * it cannot be detached or replaced. To rotate key material, rotate the underlying
     * key on your cloud KMS; the `external_key_id` stays the same.
     * @param array<string,string>|null $tags Body param: User-defined tags as string key-value pairs. Keys may not begin with `anthropic`.
     * @param string|null $userProfileID Body param: ID of a user profile to attach to the Workspace. Every inference request through the Workspace must then name this user profile; the API rejects a request that names none or a different one. The user profile can't be replaced or removed later; only deleting the user profile clears it.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: Optional header to specify the beta version(s) you want to use.
     * @param RequestOpts|null $requestOptions
     *
     * @throws ExternalKeyValidationFailedException
     * @throws ExternalKeyValidationTimedOutException
     * @throws KeyProfileMismatchException
     * @throws UserProfileNotFoundException
     * @throws WorkspacePolicyViolationException
     * @throws ExternalKeyChangedException
     * @throws APIException
     */
    public function create(
        string $name,
        DataResidencyCreateConfig|array|null $dataResidency = null,
        ?string $displayColor = null,
        ?string $externalKeyID = null,
        ?array $tags = null,
        ?string $userProfileID = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): Workspace {
        $params = Util::removeNulls(
            [
                'name' => $name,
                'dataResidency' => $dataResidency,
                'displayColor' => $displayColor,
                'externalKeyID' => $externalKeyID,
                'tags' => $tags,
                'userProfileID' => $userProfileID,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get Workspace
     *
     * @param string $workspaceID ID of the Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null
    ): Workspace {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($workspaceID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update Workspace
     *
     * @param DataResidencyUpdateConfig|DataResidencyUpdateConfigShape|null $dataResidency Data residency configuration for the workspace.
     * @param string $displayColor Hex color code representing the Workspace in the Anthropic Console.
     * @param string $externalKeyID ID of the customer-managed encryption key (CMEK) configuration to use for this
     * Workspace. Setting this field requires CMEK to be enabled for your
     * organization. When set, data stored for this Workspace is encrypted with the
     * referenced key. Create key configurations with the External Keys API. On
     * Claude Platform on AWS the value for an AWS KMS key is the key's ARN, and your
     * organization's own key must be a single-Region key in the same AWS account and
     * Region as the Workspace. On that platform the key is validated against this
     * Workspace when it is attached, so a key-policy problem is reported as an error
     * on this request. This field is write-once: once a key is attached to a Workspace
     * it cannot be detached or replaced. To rotate key material, rotate the underlying
     * key on your cloud KMS; the `external_key_id` stays the same.
     * @param string $name Name of the Workspace.
     * @param array<string,string|null>|null $tags User-defined tags as string key-value pairs. Keys may not begin with `anthropic`.
     * @param string $userProfileID ID of a user profile to attach to the Workspace. Every inference request through the Workspace must then name this user profile; the API rejects a request that names none or a different one. Once set, it can't be replaced or removed (sending the same ID again changes nothing); only deleting the user profile clears it. The default Workspace can't have a user profile.
     * @param RequestOpts|null $requestOptions
     *
     * @throws ExternalKeyValidationFailedException
     * @throws ExternalKeyValidationTimedOutException
     * @throws KeyProfileMismatchException
     * @throws UserProfileNotFoundException
     * @throws WorkspacePolicyViolationException
     * @throws ExternalKeyChangedException
     * @throws APIException
     */
    public function update(
        string $workspaceID,
        DataResidencyUpdateConfig|array|null $dataResidency = null,
        ?string $displayColor = null,
        ?string $externalKeyID = null,
        ?string $name = null,
        ?array $tags = null,
        ?string $userProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): Workspace {
        $params = Util::removeNulls(
            [
                'dataResidency' => $dataResidency,
                'displayColor' => $displayColor,
                'externalKeyID' => $externalKeyID,
                'name' => $name,
                'tags' => $tags,
                'userProfileID' => $userProfileID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($workspaceID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List Workspaces
     *
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param list<string> $ids Only the Workspaces with these IDs, at most 100. `include_archived` and `include_default` still apply, and IDs of Workspaces the caller can't list are left out.
     * @param bool $includeArchived Whether to include Workspaces that have been archived in the response
     * @param bool $includeDefault Whether to include the organization's default Workspace in the response
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
        ?array $ids = null,
        ?bool $includeArchived = null,
        ?bool $includeDefault = null,
        ?int $limit = null,
        RequestOptions|array|null $requestOptions = null,
    ): Page {
        $params = Util::removeNulls(
            [
                'afterID' => $afterID,
                'beforeID' => $beforeID,
                'ids' => $ids,
                'includeArchived' => $includeArchived,
                'includeDefault' => $includeDefault,
                'limit' => $limit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Archive Workspace
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null
    ): Workspace {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->archive($workspaceID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
