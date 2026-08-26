<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Federation;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Federation\Rules\BetaFederationRule;
use Anthropic\Beta\Organization\Federation\Rules\BetaFederationRuleMatch;
use Anthropic\Beta\Organization\Federation\Rules\BetaServiceAccountTarget;
use Anthropic\Beta\Organization\Federation\Rules\RuleArchiveParams;
use Anthropic\Beta\Organization\Federation\Rules\RuleCreateParams;
use Anthropic\Beta\Organization\Federation\Rules\RuleListParams;
use Anthropic\Beta\Organization\Federation\Rules\RuleRetrieveParams;
use Anthropic\Beta\Organization\Federation\Rules\RuleUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Federation\RulesRawContract;

/**
 * @phpstan-import-type BetaFederationRuleMatchShape from \Anthropic\Beta\Organization\Federation\Rules\BetaFederationRuleMatch
 * @phpstan-import-type BetaServiceAccountTargetShape from \Anthropic\Beta\Organization\Federation\Rules\BetaServiceAccountTarget
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class RulesRawService implements RulesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Create a federation rule owned by your organization.
     *
     * The referenced issuer and the target service account must already exist
     * in the same organization; invalid references are rejected with a 400
     * error. The workspace reference is validated. Membership is not checked
     * at rule creation: token exchange resolves a single enabled workspace per
     * call and is rejected unless the target service account is a member of
     * that workspace (it is implicitly a member of the default workspace).
     * Rules on well-known shared issuers (GitHub Actions, GitLab, Buildkite,
     * Terraform Cloud, Google) must constrain tenant identity via an
     * identity-bearing claim, a tenant-pinning subject prefix (such as
     * `repo:YOUR_ORG/...`), or a CEL condition referencing one of those
     * identity claims (e.g. `claims.repository_owner`). OAuth callers may only
     * manage rules whose `oauth_scope` is `workspace:developer` or
     * `workspace:inference`; other scopes require a Console session.
     *
     * @param array{
     *   issuerID: string,
     *   match: BetaFederationRuleMatch|BetaFederationRuleMatchShape,
     *   name: string,
     *   oauthScope: string,
     *   target: BetaServiceAccountTarget|BetaServiceAccountTargetShape,
     *   appliesToAllWorkspaces?: bool,
     *   attributes?: array<string,string>|null,
     *   description?: string|null,
     *   tokenLifetimeSeconds?: int,
     *   workspaceID?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|RuleCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaFederationRule>
     *
     * @throws APIException
     */
    public function create(
        array|RuleCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RuleCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/federation_rules?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: BetaFederationRule::class,
        );
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Retrieve a federation rule by its ID (`fdrl_...`).
     *
     * @param string $federationRuleID ID of the federation rule
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|RuleRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaFederationRule>
     *
     * @throws APIException
     */
    public function retrieve(
        string $federationRuleID,
        array|RuleRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RuleRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/federation_rules/%1$s?beta=true', $federationRuleID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: BetaFederationRule::class,
        );
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Partially update a federation rule.
     *
     * `issuer_id` is immutable. `match` and `target` are replaced as whole
     * objects when set. Referenced service accounts and workspaces must exist
     * in your organization; invalid references are rejected with a 400 error.
     * Archived rules cannot be updated; this returns 400. Create a new rule
     * instead. Rules on well-known shared issuers (GitHub Actions, GitLab,
     * Buildkite, Terraform Cloud, Google) must constrain tenant identity via
     * an identity-bearing claim, a tenant-pinning subject prefix (such as
     * `repo:YOUR_ORG/...`), or a CEL condition referencing one of those
     * identity claims (e.g. `claims.repository_owner`). On these issuers the
     * requirement is re-checked on every update; if an existing rule's stored
     * match does not yet constrain tenant identity, any update (even a rename
     * or description change) must also supply a conforming `match` in the same
     * request. OAuth callers may only manage rules whose `oauth_scope` is
     * `workspace:developer` or `workspace:inference`; other scopes require a
     * Console session.
     *
     * @param string $federationRuleID path param: ID of the federation rule to update
     * @param array{
     *   appliesToAllWorkspaces?: bool|null,
     *   attributes?: array<string,string>|null,
     *   description?: string|null,
     *   match?: BetaFederationRuleMatch|BetaFederationRuleMatchShape|null,
     *   name?: string|null,
     *   oauthScope?: string|null,
     *   target?: BetaServiceAccountTarget|BetaServiceAccountTargetShape|null,
     *   tokenLifetimeSeconds?: int|null,
     *   workspaceID?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|RuleUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaFederationRule>
     *
     * @throws APIException
     */
    public function update(
        string $federationRuleID,
        array|RuleUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RuleUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/federation_rules/%1$s?beta=true', $federationRuleID,
            ],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: BetaFederationRule::class,
        );
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * List federation rules in your organization.
     *
     * Optionally filter by issuer with `issuer_id`. Archived rules are excluded
     * unless `include_archived=true`.
     *
     * @param array{
     *   includeArchived?: bool,
     *   issuerID?: string|null,
     *   limit?: int,
     *   page?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|RuleListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaFederationRule>>
     *
     * @throws APIException
     */
    public function list(
        array|RuleListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RuleListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            ['includeArchived', 'issuerID', 'limit', 'page']
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/federation_rules?beta=true',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['includeArchived' => 'include_archived', 'issuerID' => 'issuer_id'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: BetaFederationRule::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Archive a federation rule.
     *
     * Token exchange through this rule stops immediately. Idempotent;
     * re-archiving returns the rule with its original `archived_at`. Archiving
     * clears the rule's workspace targeting (`workspace_id` and
     * `workspace_ids` are emptied). Tokens already minted before archive
     * remain valid until they expire. OAuth callers may only manage rules
     * whose `oauth_scope` is `workspace:developer` or `workspace:inference`;
     * other scopes require a Console session.
     *
     * @param string $federationRuleID ID of the federation rule to archive
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|RuleArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaFederationRule>
     *
     * @throws APIException
     */
    public function archive(
        string $federationRuleID,
        array|RuleArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RuleArchiveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/federation_rules/%1$s/archive?beta=true',
                $federationRuleID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: BetaFederationRule::class,
        );
    }
}
