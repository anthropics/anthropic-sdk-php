<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\UserProfiles\Providers\Google;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKDisabledParams;
use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKEnabledParams;
use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedDataControls;
use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageDisabledParams;
use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageEnabledParams;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type BetaGoogleManagedCMEKControlParamsShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKControlParams
 * @phpstan-import-type BetaGoogleManagedStorageControlParamsShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageControlParams
 */
interface DataControlsContract
{
    /**
     * @api
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
    ): BetaGoogleManagedDataControls;

    /**
     * @api
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
    ): BetaGoogleManagedDataControls;
}
