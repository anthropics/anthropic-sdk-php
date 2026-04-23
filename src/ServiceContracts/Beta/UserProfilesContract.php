<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\UserProfiles\BetaUserProfile;
use Anthropic\Beta\UserProfiles\BetaUserProfileEnrollmentURL;
use Anthropic\Beta\UserProfiles\UserProfileListParams\Order;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface UserProfilesContract
{
    /**
     * @api
     *
     * @param string|null $externalID Body param: Platform's own identifier for this user. Not enforced unique. Maximum 255 characters.
     * @param array<string,string> $metadata Body param: Free-form key-value data to attach to this user profile. Maximum 16 keys, with keys up to 64 characters and values up to 512 characters. Values must be non-empty strings.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $externalID = null,
        ?array $metadata = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaUserProfile;

    /**
     * @api
     *
     * @param string $userProfileID Path parameter user_profile_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $userProfileID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaUserProfile;

    /**
     * @api
     *
     * @param string $userProfileID Path param: Path parameter user_profile_id
     * @param string|null $externalID Body param: If present, replaces the stored external_id. Omit to leave unchanged. Maximum 255 characters.
     * @param array<string,string> $metadata Body param: Key-value pairs to merge into the stored metadata. Keys provided overwrite existing values. To remove a key, set its value to an empty string. Keys not provided are left unchanged. Maximum 16 keys, with keys up to 64 characters and values up to 512 characters.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $userProfileID,
        ?string $externalID = null,
        ?array $metadata = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaUserProfile;

    /**
     * @api
     *
     * @param int $limit Query param: Query parameter for limit
     * @param Order|value-of<Order> $order Query param: Query parameter for order
     * @param string $page Query param: Query parameter for page
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaUserProfile>
     *
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        Order|string|null $order = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $userProfileID Path parameter user_profile_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createEnrollmentURL(
        string $userProfileID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaUserProfileEnrollmentURL;
}
