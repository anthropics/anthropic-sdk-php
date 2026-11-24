<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\UserProfiles\Providers\Google;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKDisabledParams;
use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKEnabledParams;
use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedDataControls;
use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageDisabledParams;
use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageEnabledParams;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\UserProfiles\Providers\Google\DataControlsContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type BetaGoogleManagedCMEKControlParamsShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKControlParams
 * @phpstan-import-type BetaGoogleManagedStorageControlParamsShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageControlParams
 */
final class DataControlsService implements DataControlsContract
{
    /**
     * @api
     */
    public DataControlsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new DataControlsRawService($client);
    }

    /**
     * @api
     *
     * Get the profile's encryption keys and storage buckets for Claude on Google Cloud's Agent Platform, with each region's status.
     *
     * @param string $userProfileID The ID of the user profile whose Google-managed data controls to retrieve (`uprof_...`).
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas This endpoint is in beta: requests must send `google-managed-data-controls-2026-09-01` in this header.
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
    ): BetaGoogleManagedDataControls {
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
     * Turn a control on or off, or change the key or bucket set for a region. Controls and regions that you leave out stay as they are.
     *
     * @param string $userProfileID Path param: The ID of the user profile whose Google-managed data controls to update (`uprof_...`).
     * @param BetaGoogleManagedCMEKControlParamsShape $cmek Body param: The customer-managed encryption key control. Leave it out to keep the control as it is. Send `cmek`, `storage`, or both.
     * @param BetaGoogleManagedStorageControlParamsShape $storage Body param: The customer-owned storage control. Leave it out to keep the control as it is. Send `cmek`, `storage`, or both.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: This endpoint is in beta: requests must send `google-managed-data-controls-2026-09-01` in this header.
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $userProfileID,
        BetaGoogleManagedCMEKDisabledParams|array|BetaGoogleManagedCMEKEnabledParams|null $cmek = null,
        BetaGoogleManagedStorageDisabledParams|array|BetaGoogleManagedStorageEnabledParams|null $storage = null,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaGoogleManagedDataControls {
        $params = Util::removeNulls(
            [
                'cmek' => $cmek,
                'storage' => $storage,
                'betas' => $betas,
                'workspaceID' => $workspaceID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($userProfileID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
