<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Beta\BetaRequestBodyTimeoutException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaSettingsDocumentLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaSettingsHistoryLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\BetaClaudeCodeManagedSettingsConfiguration;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\ConfigurationRetrieveParams;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\ConfigurationUpdateParams;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ConfigurationRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ConfigurationRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeCodeManagedSettingsConfiguration>
     *
     * @throws APIException
     */
    public function retrieve(
        array|ConfigurationRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ConfigurationUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeCodeManagedSettingsConfiguration>
     *
     * @throws CMEKKeyDisabledException
     * @throws BetaRequestBodyTimeoutException
     * @throws BetaSettingsDocumentLimitExceededException
     * @throws BetaSettingsHistoryLimitExceededException
     * @throws SandboxEgressRestrictedException
     * @throws APIException
     */
    public function update(
        array|ConfigurationUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
