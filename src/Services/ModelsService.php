<?php

declare(strict_types=1);

namespace Anthropic\Services;

use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Models\ModelInfo;
use Anthropic\Models\ModelListParams;
use Anthropic\Models\ModelRetrieveParams;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\ModelsContract;

final class ModelsService implements ModelsContract
{
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
     * @param array{betas?: list<string>}|ModelRetrieveParams $params
     *
     * @throws APIException
     */
    public function retrieve(
        string $modelID,
        array|ModelRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): ModelInfo {
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
                ['betas' => 'anthropic-beta']
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
     *   after_id?: string, before_id?: string, limit?: int, betas?: list<string>
     * }|ModelListParams $params
     *
     * @return Page<ModelInfo>
     *
     * @throws APIException
     */
    public function list(
        array|ModelListParams $params,
        ?RequestOptions $requestOptions = null
    ): Page {
        [$parsed, $options] = ModelListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['after_id', 'before_id', 'limit']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/models',
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: ModelInfo::class,
            page: Page::class,
        );
    }
}
