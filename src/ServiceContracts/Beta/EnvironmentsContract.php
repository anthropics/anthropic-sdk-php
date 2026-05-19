<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Environments\BetaCloudConfigParams;
use Anthropic\Beta\Environments\BetaEnvironment;
use Anthropic\Beta\Environments\BetaEnvironmentDeleteResponse;
use Anthropic\Beta\Environments\BetaSelfHostedConfigParams;
use Anthropic\Beta\Environments\EnvironmentCreateParams\Scope;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type ConfigShape from \Anthropic\Beta\Environments\EnvironmentCreateParams\Config
 * @phpstan-import-type ConfigShape from \Anthropic\Beta\Environments\EnvironmentUpdateParams\Config as ConfigShape1
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface EnvironmentsContract
{
    /**
     * @api
     *
     * @param string $name Body param: Human-readable name for the environment
     * @param ConfigShape|null $config Body param: Environment configuration
     * @param string|null $description Body param: Optional description of the environment
     * @param array<string,string> $metadata Body param: User-provided metadata key-value pairs
     * @param Scope|value-of<Scope>|null $scope Body param: The visibility scope for this environment. 'organization' makes the environment visible to all accounts. 'account' restricts visibility to the owning account only. Only applicable for self-hosted environments. If not specified, defaults based on organization type.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $name,
        BetaCloudConfigParams|array|BetaSelfHostedConfigParams|null $config = null,
        ?string $description = null,
        ?array $metadata = null,
        Scope|string|null $scope = null,
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
     * @param ConfigShape1|null $config Body param: Updated environment configuration
     * @param string|null $description Body param: Updated description of the environment
     * @param array<string,string|null> $metadata Body param: User-provided metadata key-value pairs. Set a value to null or empty string to delete the key.
     * @param string|null $name Body param: Updated name for the environment
     * @param \Anthropic\Beta\Environments\EnvironmentUpdateParams\Scope|value-of<\Anthropic\Beta\Environments\EnvironmentUpdateParams\Scope>|null $scope Body param: The visibility scope for this environment. 'organization' makes the environment visible to all accounts. 'account' restricts visibility to the owning account only.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $environmentID,
        BetaCloudConfigParams|array|BetaSelfHostedConfigParams|null $config = null,
        ?string $description = null,
        ?array $metadata = null,
        ?string $name = null,
        \Anthropic\Beta\Environments\EnvironmentUpdateParams\Scope|string|null $scope = null,
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
