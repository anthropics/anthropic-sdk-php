<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Beta\BetaRequestBodyTimeoutException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaCMEKFeatureUnsupportedException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaSettingsDocumentLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaSettingsHistoryLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroupDefault\BetaClaudeCodeRBACGroupDefaultManagedSettings;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroupDefault\RBACGroupDefaultRetrieveParams;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroupDefault\RBACGroupDefaultUpdateParams;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface RBACGroupDefaultRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|RBACGroupDefaultRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeCodeRBACGroupDefaultManagedSettings>
     *
     * @throws BetaCMEKFeatureUnsupportedException
     * @throws CMEKKeyDisabledException
     * @throws APIException
     */
    public function retrieve(
        array|RBACGroupDefaultRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|RBACGroupDefaultUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeCodeRBACGroupDefaultManagedSettings>
     *
     * @throws BetaCMEKFeatureUnsupportedException
     * @throws CMEKKeyDisabledException
     * @throws BetaRequestBodyTimeoutException
     * @throws BetaSettingsDocumentLimitExceededException
     * @throws BetaSettingsHistoryLimitExceededException
     * @throws SandboxEgressRestrictedException
     * @throws APIException
     */
    public function update(
        array|RBACGroupDefaultUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
