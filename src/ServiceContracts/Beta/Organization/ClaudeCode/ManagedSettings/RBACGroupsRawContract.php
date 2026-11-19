<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Beta\BetaRequestBodyTimeoutException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaCMEKFeatureUnsupportedException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaRBACGroupManagedSettingsNotFoundException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaRBACGroupOrderLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaSettingsDocumentLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaSettingsHistoryLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\BetaClaudeCodeRBACGroupManagedSettings;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\BetaClaudeCodeRBACGroupManagedSettingsSummary;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\BetaDeletedClaudeCodeRBACGroupManagedSettings;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\RBACGroupDeleteParams;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\RBACGroupListParams;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\RBACGroupRetrieveParams;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\RBACGroupSetParams;
use Anthropic\Beta\Organization\RBACGroups\RBACGroupNotFoundException;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface RBACGroupsRawContract
{
    /**
     * @api
     *
     * @param string $rbacGroupID The RBAC Group's ID, prefixed `rbac_group_`.
     * @param array<string,mixed>|RBACGroupRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeCodeRBACGroupManagedSettings>
     *
     * @throws BetaCMEKFeatureUnsupportedException
     * @throws CMEKKeyDisabledException
     * @throws BetaRBACGroupManagedSettingsNotFoundException
     * @throws APIException
     */
    public function retrieve(
        string $rbacGroupID,
        array|RBACGroupRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|RBACGroupListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaClaudeCodeRBACGroupManagedSettingsSummary>>
     *
     * @throws APIException
     */
    public function list(
        array|RBACGroupListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $rbacGroupID The RBAC Group's ID, prefixed `rbac_group_`.
     * @param array<string,mixed>|RBACGroupDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaDeletedClaudeCodeRBACGroupManagedSettings>
     *
     * @throws CMEKKeyDisabledException
     * @throws BetaSettingsHistoryLimitExceededException
     * @throws SandboxEgressRestrictedException
     * @throws BetaRBACGroupManagedSettingsNotFoundException
     * @throws APIException
     */
    public function delete(
        string $rbacGroupID,
        array|RBACGroupDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $rbacGroupID Path param: The RBAC Group's ID, prefixed `rbac_group_`.
     * @param array<string,mixed>|RBACGroupSetParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeCodeRBACGroupManagedSettings>
     *
     * @throws BetaCMEKFeatureUnsupportedException
     * @throws CMEKKeyDisabledException
     * @throws BetaRBACGroupOrderLimitExceededException
     * @throws BetaRequestBodyTimeoutException
     * @throws BetaSettingsDocumentLimitExceededException
     * @throws BetaSettingsHistoryLimitExceededException
     * @throws SandboxEgressRestrictedException
     * @throws RBACGroupNotFoundException
     * @throws APIException
     */
    public function set(
        string $rbacGroupID,
        array|RBACGroupSetParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
