<?php

declare(strict_types=1);

namespace Anthropic\Services;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Models\ModelInfo;
use Anthropic\Models\ModelListParams;
use Anthropic\Models\ModelRetrieveParams;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\ModelsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ModelsRawService implements ModelsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get a specific model.
     *
     * The Models API response can be used to determine information about a specific model or resolve a model alias to a model ID.
     *
     * @param string $modelID model identifier or alias
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|ModelRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ModelInfo>
     *
     * @throws APIException
     */
    public function retrieve(
        string $modelID,
        array|ModelRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ModelRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/models/%1$s', $modelID],
            headers: Util::array_transform_keys(
                $parsed,
                [
                    'betas' => 'anthropic-beta', 'workspaceID' => 'anthropic-workspace-id',
                ],
            ),
            options: $options,
            convert: ModelInfo::class,
        );
    }

    /**
     * @api
     *
     * List available models.
     *
     * The Models API response can be used to determine which models are available for use in the API. More recently released models are listed first.
     *
     * @param array{
     *   afterID?: string,
     *   beforeID?: string,
     *   limit?: int,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|ModelListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Page<ModelInfo>>
     *
     * @throws APIException
     */
    public function list(
        array|ModelListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ModelListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['afterID', 'beforeID', 'limit']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/models',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['afterID' => 'after_id', 'beforeID' => 'before_id'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                [
                    'betas' => 'anthropic-beta', 'workspaceID' => 'anthropic-workspace-id',
                ],
            ),
            options: $options,
            convert: ModelInfo::class,
            page: Page::class,
        );
    }
}
