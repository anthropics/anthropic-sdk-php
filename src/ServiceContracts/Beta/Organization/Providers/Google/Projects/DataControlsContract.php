<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Providers\Google\Projects;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\BetaCMEKNotApprovedException;
use Anthropic\Beta\BetaExternalKeyNotFoundException;
use Anthropic\Beta\BetaExternalKeyProviderMismatchException;
use Anthropic\Beta\BetaGCPProjectControlledByAnotherOrganizationException;
use Anthropic\Beta\BetaGCPProjectNotVerifiedException;
use Anthropic\Beta\BetaRegionNotSupportedException;
use Anthropic\Beta\BetaStorageInUseException;
use Anthropic\Beta\BetaStorageNotApprovedException;
use Anthropic\Beta\Organization\BetaAuthorizationCheckUnavailableException;
use Anthropic\Beta\Organization\BetaOrganizationNotEligibleException;
use Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKDisabledParams;
use Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKEnabledParams;
use Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectDataControls;
use Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageDisabledParams;
use Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageEnabledParams;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\Workspaces\KeyProfileMismatchException;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type BetaGoogleManagedProjectCMEKControlParamsShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKControlParams
 * @phpstan-import-type BetaGoogleManagedProjectStorageControlParamsShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageControlParams
 */
interface DataControlsContract
{
    /**
     * @api
     *
     * @param string $projectNumber The Google Cloud project's number, such as `123456789012`, not its project ID.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas This endpoint is in beta: requests must send `google-managed-data-controls-2026-09-01` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $projectNumber,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaGoogleManagedProjectDataControls;

    /**
     * @api
     *
     * @param string $projectNumber Path param: The Google Cloud project's number, such as `123456789012`, not its project ID.
     * @param BetaGoogleManagedProjectCMEKControlParamsShape $cmek Body param: The customer-managed encryption key control. Leave it out to keep the control as it is. Send `cmek`, `storage`, or both.
     * @param BetaGoogleManagedProjectStorageControlParamsShape $storage Body param: The customer-owned storage control. Leave it out to keep the control as it is. Send `cmek`, `storage`, or both.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: This endpoint is in beta: requests must send `google-managed-data-controls-2026-09-01` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws BetaCMEKNotApprovedException
     * @throws BetaExternalKeyNotFoundException
     * @throws BetaExternalKeyProviderMismatchException
     * @throws BetaGCPProjectNotVerifiedException
     * @throws KeyProfileMismatchException
     * @throws BetaOrganizationNotEligibleException
     * @throws BetaRegionNotSupportedException
     * @throws BetaStorageNotApprovedException
     * @throws SandboxEgressRestrictedException
     * @throws BetaGCPProjectControlledByAnotherOrganizationException
     * @throws BetaStorageInUseException
     * @throws BetaAuthorizationCheckUnavailableException
     * @throws APIException
     */
    public function update(
        string $projectNumber,
        BetaGoogleManagedProjectCMEKDisabledParams|array|BetaGoogleManagedProjectCMEKEnabledParams|null $cmek = null,
        BetaGoogleManagedProjectStorageDisabledParams|array|BetaGoogleManagedProjectStorageEnabledParams|null $storage = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaGoogleManagedProjectDataControls;
}
