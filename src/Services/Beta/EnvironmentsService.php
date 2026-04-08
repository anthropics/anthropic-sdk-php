<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Environments\BetaCloudConfigParams;
use Anthropic\Beta\Environments\BetaEnvironment;
use Anthropic\Beta\Environments\BetaEnvironmentDeleteResponse;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\EnvironmentsContract;

/**
 * @phpstan-import-type BetaCloudConfigParamsShape from \Anthropic\Beta\Environments\BetaCloudConfigParams
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class EnvironmentsService implements EnvironmentsContract
{
    /**
     * @api
     */
    public EnvironmentsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new EnvironmentsRawService($client);
    }

    /**
     * @api
     *
     * Create a new environment with the specified configuration.
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
    ): BetaEnvironment {
        $params = Util::removeNulls(
            [
                'name' => $name,
                'config' => $config,
                'description' => $description,
                'metadata' => $metadata,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieve a specific environment by ID.
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
    ): BetaEnvironment {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($environmentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update an existing environment's configuration.
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
    ): BetaEnvironment {
        $params = Util::removeNulls(
            [
                'config' => $config,
                'description' => $description,
                'metadata' => $metadata,
                'name' => $name,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($environmentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List environments with pagination support.
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
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'includeArchived' => $includeArchived,
                'limit' => $limit,
                'page' => $page,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete an environment by ID. Returns a confirmation of the deletion.
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
    ): BetaEnvironmentDeleteResponse {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($environmentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Archive an environment by ID. Archived environments cannot be used to create new sessions.
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
    ): BetaEnvironment {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->archive($environmentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
