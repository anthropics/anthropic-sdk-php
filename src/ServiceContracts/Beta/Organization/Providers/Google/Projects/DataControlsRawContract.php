<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Providers\Google\Projects;

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
use Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectDataControls;
use Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\DataControlRetrieveParams;
use Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\DataControlUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\Workspaces\KeyProfileMismatchException;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface DataControlsRawContract
{
    /**
     * @api
     *
     * @param string $projectNumber The Google Cloud project's number, such as `123456789012`, not its project ID.
     * @param array<string,mixed>|DataControlRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaGoogleManagedProjectDataControls>
     *
     * @throws APIException
     */
    public function retrieve(
        string $projectNumber,
        array|DataControlRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $projectNumber Path param: The Google Cloud project's number, such as `123456789012`, not its project ID.
     * @param array<string,mixed>|DataControlUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaGoogleManagedProjectDataControls>
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
        array|DataControlUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
