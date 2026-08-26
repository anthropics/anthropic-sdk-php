<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Federation;

use Anthropic\Beta\Organization\Federation\Rules\BetaFederationRule;
use Anthropic\Beta\Organization\Federation\Rules\RuleArchiveParams;
use Anthropic\Beta\Organization\Federation\Rules\RuleCreateParams;
use Anthropic\Beta\Organization\Federation\Rules\RuleListParams;
use Anthropic\Beta\Organization\Federation\Rules\RuleRetrieveParams;
use Anthropic\Beta\Organization\Federation\Rules\RuleUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface RulesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|RuleCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaFederationRule>
     *
     * @throws APIException
     */
    public function create(
        array|RuleCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $federationRuleID ID of the federation rule
     * @param array<string,mixed>|RuleRetrieveParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $federationRuleID path param: ID of the federation rule to update
     * @param array<string,mixed>|RuleUpdateParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|RuleListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaFederationRule>>
     *
     * @throws APIException
     */
    public function list(
        array|RuleListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $federationRuleID ID of the federation rule to archive
     * @param array<string,mixed>|RuleArchiveParams $params
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
    ): BaseResponse;
}
