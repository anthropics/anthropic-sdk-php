<?php

declare(strict_types=1);

namespace Anthropic\Services;

use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\UserProfilesContract;
use Anthropic\Services\UserProfiles\ActionURLsService;
use Anthropic\UserProfiles\DeletedUserProfile;
use Anthropic\UserProfiles\UserProfile;
use Anthropic\UserProfiles\UserProfileAccessType;
use Anthropic\UserProfiles\UserProfileEnforcementStatus;
use Anthropic\UserProfiles\UserProfileExternalUserDetailsParams;
use Anthropic\UserProfiles\UserProfileListOrder;
use Anthropic\UserProfiles\UserProfileListOrderBy;

/**
 * @phpstan-import-type UserProfileExternalUserDetailsParamsShape from \Anthropic\UserProfiles\UserProfileExternalUserDetailsParams
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class UserProfilesService implements UserProfilesContract
{
    /**
     * @api
     */
    public UserProfilesRawService $raw;

    /**
     * @api
     */
    public ActionURLsService $actionURLs;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new UserProfilesRawService($client);
        $this->actionURLs = new ActionURLsService($client);
    }

    /**
     * @api
     *
     * Create User Profile
     *
     * @param UserProfileAccessType|value-of<UserProfileAccessType> $accessType Body param: How the platform uses the API for this entity. `application` (default): the profile represents an individual end-user of the platform's product. `passthrough`: the profile identifies a company the platform resells Claude access to.
     * @param UserProfileExternalUserDetailsParams|UserProfileExternalUserDetailsParamsShape $externalUserDetails Body param: Details about the entity this profile represents, as the platform states them. Every field is optional. Not accepted under the legacy `user-profiles-2026-03-24` and `user-profiles-2026-08-18` beta headers, which take the top-level `external_id` (and, under `user-profiles-2026-08-18`, `external_user_onboarded_at`) instead.
     * @param array<string,string> $metadata Body param: Free-form key-value data to attach to this user profile. Maximum 16 keys, with keys up to 64 characters and values up to 512 characters. Values must be non-empty strings.
     * @param string|null $name Body param: Optional for all profiles. Real-world name of the entity this profile represents (company or individual); for a company the platform resells Claude access to (`access_type` `passthrough`), that company's name where known. Maximum 255 characters.
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        UserProfileAccessType|string|null $accessType = null,
        UserProfileExternalUserDetailsParams|array|null $externalUserDetails = null,
        ?array $metadata = null,
        ?string $name = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): UserProfile {
        $params = Util::removeNulls(
            [
                'accessType' => $accessType,
                'externalUserDetails' => $externalUserDetails,
                'metadata' => $metadata,
                'name' => $name,
                'workspaceID' => $workspaceID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get User Profile
     *
     * @param string $userProfileID The ID of the user profile to get (`uprof_...`).
     * @param string $workspaceID Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $userProfileID,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): UserProfile {
        $params = Util::removeNulls(['workspaceID' => $workspaceID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($userProfileID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update User Profile
     *
     * @param string $userProfileID Path param: The ID of the user profile to update (`uprof_...`).
     * @param UserProfileAccessType|value-of<UserProfileAccessType>|null $accessType Body param: If present, replaces the stored access type. Omit to leave unchanged.
     * @param UserProfileExternalUserDetailsParams|UserProfileExternalUserDetailsParamsShape $externalUserDetails Body param: Details about the entity this profile represents, as the platform states them. Each field sent replaces the stored value; omit a field to leave it unchanged. Once set, a value cannot be cleared and `null` is rejected. Not accepted under the legacy `user-profiles-2026-03-24` and `user-profiles-2026-08-18` beta headers.
     * @param array<string,string> $metadata Body param: Key-value pairs to merge into the stored metadata. Keys provided overwrite existing values. To remove a key, set its value to an empty string. Keys not provided are left unchanged. Maximum 16 keys, with keys up to 64 characters and values up to 512 characters.
     * @param string|null $name Body param: If present, replaces the stored name. Omit to leave unchanged. Maximum 255 characters.
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $userProfileID,
        UserProfileAccessType|string|null $accessType = null,
        UserProfileExternalUserDetailsParams|array|null $externalUserDetails = null,
        ?array $metadata = null,
        ?string $name = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): UserProfile {
        $params = Util::removeNulls(
            [
                'accessType' => $accessType,
                'externalUserDetails' => $externalUserDetails,
                'metadata' => $metadata,
                'name' => $name,
                'workspaceID' => $workspaceID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($userProfileID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List User Profiles
     *
     * @param list<UserProfileEnforcementStatus|value-of<UserProfileEnforcementStatus>> $enforcementStatus Query param: Return only the user profiles whose `enforcement_status` is one of these values: `unrestricted`, `pending`, `restricted` or `banned`. Repeat the parameter to match any of several. With it set, a page may hold fewer than `limit` profiles, or none, and still carry a `next_page`: the service examines a bounded number of profiles per request, and only a null `next_page` means the listing is complete. Rejected with `invalid_request_error` under the `user-profiles-2026-09-04` and earlier beta headers. Fails with `overloaded_error` when a profile's enforcement actions cannot be read for the moment.
     * @param int $limit Query param: The maximum number of user profiles to return, from 1 to 100. Defaults to 20.
     * @param UserProfileListOrder|value-of<UserProfileListOrder> $order Query param: The sort direction, applied to the field that `order_by` selects. Defaults to `desc`.
     * @param UserProfileListOrderBy|value-of<UserProfileListOrderBy> $orderBy Query param: The field to sort user profiles by, in the direction that `order` sets. Defaults to `created_at`.
     * @param string $page Query param: The cursor for the page to return, taken from `next_page` in a previous response.
     *
     * Leave it out to get the first page.
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<UserProfile>
     *
     * @throws APIException
     */
    public function list(
        ?array $enforcementStatus = null,
        ?int $limit = null,
        UserProfileListOrder|string|null $order = null,
        UserProfileListOrderBy|string|null $orderBy = null,
        ?string $page = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'enforcementStatus' => $enforcementStatus,
                'limit' => $limit,
                'order' => $order,
                'orderBy' => $orderBy,
                'page' => $page,
                'workspaceID' => $workspaceID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete User Profile
     *
     * @param string $userProfileID The ID of the user profile to delete (`uprof_...`).
     * @param string $workspaceID Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $userProfileID,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): DeletedUserProfile {
        $params = Util::removeNulls(['workspaceID' => $workspaceID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($userProfileID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
