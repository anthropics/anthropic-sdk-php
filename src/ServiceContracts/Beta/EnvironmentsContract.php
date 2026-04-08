<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Environments\BetaCloudConfigParams;
use Anthropic\Beta\Environments\BetaEnvironment;
use Anthropic\Beta\Environments\BetaEnvironmentDeleteResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type BetaCloudConfigParamsShape from \Anthropic\Beta\Environments\BetaCloudConfigParams
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface EnvironmentsContract
{
    /**
     * @api
     *
     * @param string $name Body param: Human-readable name for the environment
     * @param BetaCloudConfigParams|BetaCloudConfigParamsShape|null $config Body param: Request params for `cloud` environment configuration.
     *
     * Fields default to null; on update, omitted fields preserve the
     * existing value.
     * @param string|null $description Body param: Optional description of the environment
     * @param array<string,string> $metadata Body param: User-provided metadata key-value pairs
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $name,
        BetaCloudConfigParams|array|null $config = null,
        ?string $description = null,
        ?array $metadata = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaEnvironment;

    /**
     * @api
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $environmentID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaEnvironment;

    /**
     * @api
     *
     * @param string $environmentID Path param
     * @param BetaCloudConfigParams|BetaCloudConfigParamsShape|null $config Body param: Request params for `cloud` environment configuration.
     *
     * Fields default to null; on update, omitted fields preserve the
     * existing value.
     * @param string|null $description Body param: Updated description of the environment
     * @param array<string,string|null> $metadata Body param: User-provided metadata key-value pairs. Set a value to null or empty string to delete the key.
     * @param string|null $name Body param: Updated name for the environment
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $environmentID,
        BetaCloudConfigParams|array|null $config = null,
        ?string $description = null,
        ?array $metadata = null,
        ?string $name = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaEnvironment;

    /**
     * @api
     *
     * @param bool $includeArchived Query param: Include archived environments in the response
     * @param int $limit Query param: Maximum number of environments to return
     * @param string|null $page Query param: Opaque cursor from previous response for pagination. Pass the `next_page` value from the previous response.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaEnvironment>
     *
     * @throws APIException
     */
    public function list(
        bool $includeArchived = false,
        int $limit = 20,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $environmentID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaEnvironmentDeleteResponse;

    /**
     * @api
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $environmentID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaEnvironment;
}
