<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\UserProfiles\BetaUserProfile;
use Anthropic\Beta\UserProfiles\BetaUserProfileEnrollmentURL;
use Anthropic\Beta\UserProfiles\BetaUserProfileExternalUserDetailsParams;
use Anthropic\Beta\UserProfiles\UserProfileCreateParams\AccessType;
use Anthropic\Beta\UserProfiles\UserProfileListParams\Order;
use Anthropic\Beta\UserProfiles\UserProfileListParams\OrderBy;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\UserProfilesContract;

/**
 * @phpstan-import-type BetaUserProfileExternalUserDetailsParamsShape from \Anthropic\Beta\UserProfiles\BetaUserProfileExternalUserDetailsParams
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class UserProfilesService implements UserProfilesContract
{
    /**
     * @api
     */
    public UserProfilesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new UserProfilesRawService($client);
    }

    /**
     * @api
     *
     * Create User Profile
     *
     * @param AccessType|value-of<AccessType> $accessType Body param: How the platform uses the API on behalf of the entity this profile represents. `application`: the platform sells a product that uses the API behind the scenes, and the profile represents an individual end-user of that product. `passthrough`: the platform resells raw inference, and the profile identifies the resold-to company.
     * @param string|null $externalID Body param: Platform's own identifier for this user. Not enforced unique. Maximum 255 characters. Accepted under the `user-profiles-2026-03-24` and `user-profiles-2026-08-18` beta headers; under `user-profiles-2026-09-04` send `external_user_details.reference_id` instead.
     * @param BetaUserProfileExternalUserDetailsParams|BetaUserProfileExternalUserDetailsParamsShape $externalUserDetails Body param: Details about the entity this profile represents, as the platform states them. Every field is optional. Accepted under the `user-profiles-2026-09-04` beta header only.
     * @param \DateTimeInterface $externalUserOnboardedAt Body param: A timestamp in RFC 3339 format
     * @param array<string,string> $metadata Body param: Free-form key-value data to attach to this user profile. Maximum 16 keys, with keys up to 64 characters and values up to 512 characters. Values must be non-empty strings.
     * @param string|null $name Body param: Optional for all profiles. Real-world name of the entity this profile represents (company or individual); for a company the platform resells Claude access to (`access_type` `passthrough`), that company's name where known. Maximum 255 characters.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        AccessType|string|null $accessType = null,
        ?string $externalID = null,
        BetaUserProfileExternalUserDetailsParams|array|null $externalUserDetails = null,
        ?\DateTimeInterface $externalUserOnboardedAt = null,
        ?array $metadata = null,
        ?string $name = null,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaUserProfile {
        $params = Util::removeNulls(
            [
                'accessType' => $accessType,
                'externalID' => $externalID,
                'externalUserDetails' => $externalUserDetails,
                'externalUserOnboardedAt' => $externalUserOnboardedAt,
                'metadata' => $metadata,
                'name' => $name,
                'betas' => $betas,
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $userProfileID,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaUserProfile {
        $params = Util::removeNulls(
            ['betas' => $betas, 'workspaceID' => $workspaceID]
        );

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
     * @param \Anthropic\Beta\UserProfiles\UserProfileUpdateParams\AccessType|value-of<\Anthropic\Beta\UserProfiles\UserProfileUpdateParams\AccessType>|null $accessType Body param: How the platform uses the API on behalf of the entity this profile represents. `application`: the platform sells a product that uses the API behind the scenes, and the profile represents an individual end-user of that product. `passthrough`: the platform resells raw inference, and the profile identifies the resold-to company.
     * @param string|null $externalID Body param: If present, replaces the stored external_id. Omit to leave unchanged. Maximum 255 characters. Accepted under the `user-profiles-2026-03-24` and `user-profiles-2026-08-18` beta headers; under `user-profiles-2026-09-04` send `external_user_details.reference_id` instead.
     * @param BetaUserProfileExternalUserDetailsParams|BetaUserProfileExternalUserDetailsParamsShape $externalUserDetails Body param: Details about the entity this profile represents, as the platform states them. Each field sent replaces the stored value; omit a field to leave it unchanged. Once set, a value cannot be cleared and `null` is rejected. Accepted under the `user-profiles-2026-09-04` beta header only.
     * @param \DateTimeInterface $externalUserOnboardedAt Body param: A timestamp in RFC 3339 format
     * @param array<string,string> $metadata Body param: Key-value pairs to merge into the stored metadata. Keys provided overwrite existing values. To remove a key, set its value to an empty string. Keys not provided are left unchanged. Maximum 16 keys, with keys up to 64 characters and values up to 512 characters.
     * @param string|null $name Body param: If present, replaces the stored name. Omit to leave unchanged. Maximum 255 characters.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $userProfileID,
        \Anthropic\Beta\UserProfiles\UserProfileUpdateParams\AccessType|string|null $accessType = null,
        ?string $externalID = null,
        BetaUserProfileExternalUserDetailsParams|array|null $externalUserDetails = null,
        ?\DateTimeInterface $externalUserOnboardedAt = null,
        ?array $metadata = null,
        ?string $name = null,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaUserProfile {
        $params = Util::removeNulls(
            [
                'accessType' => $accessType,
                'externalID' => $externalID,
                'externalUserDetails' => $externalUserDetails,
                'externalUserOnboardedAt' => $externalUserOnboardedAt,
                'metadata' => $metadata,
                'name' => $name,
                'betas' => $betas,
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
     * @param int $limit Query param: The maximum number of user profiles to return, from 1 to 100. Defaults to 20.
     * @param Order|value-of<Order> $order Query param: The sort direction, applied to the field that `order_by` selects. Defaults to `desc`.
     * @param OrderBy|value-of<OrderBy> $orderBy Query param: The field to sort user profiles by, in the direction that `order` sets. Defaults to `created_at`.
     * @param string $page Query param: The cursor for the page to return, taken from `next_page` in a previous response.
     *
     * Leave it out to get the first page.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaUserProfile>
     *
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        Order|string|null $order = null,
        OrderBy|string|null $orderBy = null,
        ?string $page = null,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'limit' => $limit,
                'order' => $order,
                'orderBy' => $orderBy,
                'page' => $page,
                'betas' => $betas,
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
     * Create Enrollment URL
     *
     * @param string $userProfileID The ID of the user profile to create an enrollment URL for (`uprof_...`).
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createEnrollmentURL(
        string $userProfileID,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaUserProfileEnrollmentURL {
        $params = Util::removeNulls(
            ['betas' => $betas, 'workspaceID' => $workspaceID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->createEnrollmentURL($userProfileID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
